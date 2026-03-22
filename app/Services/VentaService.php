<?php

namespace App\Services;

use App\Models\Venta\Venta;
use App\Models\Venta\DetalleVenta;
use App\Models\Inventario\ProductoServicio;
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Venta\MetodoPago;

use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Servicio encargado de gestionar la lógica de negocio para las ventas.
 * Maneja la creación de ventas, adición de items, control de inventario básico 
 * y cálculo de impuestos/comisiones.
 */
class VentaService
{
    /**
     * Crea una nueva venta desde cero procesando un listado de items.
     * Todo el proceso se ejecuta dentro de una transacción para evitar inconsistencias 
     * en la base de datos si ocurre un error a mitad del proceso.
     *
     * @param array $items Listado de items. Estructura esperada: [['id' => int, 'cantidad' => float, 'tipo' => string<'medicamento'|'producto'>, 'nombre' => string|null]]
     * @param int $estanciaId ID de la estancia hospitalaria o médica asociada a la venta.
     * @param int $userId ID del usuario (cajero/administrador) que registra la venta.
     * @return Venta La instancia de la venta recién creada y cuantificada.
     * @throws Exception Si falla la transacción de base de datos.
     */
    public function crearVenta(array $items, int $estanciaId, int $userId): Venta
    {
        return DB::transaction(function () use ($items, $estanciaId, $userId) {

            // 1. Inicializamos la venta en estado pendiente con totales en cero
            $venta = Venta::create([
                'fecha'       => now(),
                'subtotal'    => 0,
                'total'       => 0,
                'descuento'   => 0,
                'estado'      => Venta::ESTADO_PENDIENTE,
                'estancia_id' => $estanciaId,
                'user_id'     => $userId,
            ]);

            $subtotalAcumulado = 0;
            $totalAcumulado = 0;

            // 2. Procesamos cada item para deducir inventario y calcular costos
            foreach ($items as $item) {
                $detalle = $this->procesarItem($venta, $item);
                $subtotalAcumulado += $detalle->subtotal;
                $totalAcumulado += $this->calcularTotalConImpuestos($detalle);
            }

            // 3. Actualizamos la venta con los totales reales calculados
            $venta->update([
                'subtotal' => $subtotalAcumulado,
                'total'    => $totalAcumulado,
            ]);

            return $venta;
        });
    }

    /**
     * Agrega un nuevo item a una venta existente y recalcula los totales.
     *
     * @param Venta $venta La instancia de la venta a modificar.
     * @param array $item Datos del item a agregar ['id', 'cantidad', 'tipo'].
     * @return Venta La venta actualizada.
     * @throws Exception Si falla la transacción.
     */
    public function addItemToVenta(Venta $venta, array $item): Venta
    {
        return DB::transaction(function () use ($venta, $item) {
            
            $detalle = $this->procesarItem($venta, $item);
            // Recalculamos el subtotal basándonos en la base de datos para asegurar precisión
            $nuevoSubtotal = $venta->detalles()->sum('subtotal');

            $totalNuevoItem = $this->calcularTotalConImpuestos($detalle);
            $nuevoTotalVenta = $venta->total + $totalNuevoItem;

            $venta->update([
                'subtotal' => $nuevoSubtotal,
                'total'    => $nuevoTotalVenta,
            ]);

            return $venta;
        });
    }

    /**
     * Procesa individualmente un item: busca el modelo, deduce inventario si aplica,
     * absorbe la comisión de la terminal en el precio y crea el registro de DetalleVenta.
     *
     * @param Venta $venta Instancia de la venta actual.
     * @param array $itemData Datos crudos del item provenientes del request.
     * @return DetalleVenta El detalle registrado en la base de datos.
     */
    private function procesarItem(Venta $venta, array $itemData): DetalleVenta
    {
        $id = $itemData['id'];
        $cantidad = $itemData['cantidad'];
        $tipo = $itemData['tipo']; 

        $modelo = null;
        
        $precioUnitario = 0.1; 

        $modelo = ProductoServicio::find($id);
        if ($modelo) {
            $precioUnitario = $modelo->importe ?? $precioUnitario;

            // Regla de negocio: Los servicios no tienen stock físico, solo descontamos productos/medicamentos
            if ($modelo->tipo !== 'SERVICIOS') {
                if ($modelo->cantidad >= $cantidad) {
                    $modelo->decrement('cantidad', $cantidad);
                }
            }
        }

        $iva_aplicado = ProductoServicio::IVA;
        
        // Regla de negocio: Los medicamentos están exentos de IVA (Tasa 0%)
        if ($tipo === "medicamento") {
            $iva_aplicado = 0;
        }        

        // Regla de negocio para precios: Se divide el precio entre (1 - comision) 
        // para trasladar el costo de la comisión de la terminal de pago al precio base del producto.
        $precioConComisionAbsorbida = $precioUnitario / (1 - ProductoServicio::comision_terminal);

        return DetalleVenta::create([
            'venta_id'        => $venta->id,
            'itemable_id'     => $modelo ? $modelo->id : null,          
            'itemable_type'   => $modelo ? get_class($modelo) : null,  
            'precio_unitario' => $precioConComisionAbsorbida, 
            'iva_aplicado'    => $iva_aplicado,
            'cantidad'        => $cantidad, 
            'subtotal'        => $precioConComisionAbsorbida * $cantidad, 
            'estado'          => 'completado',

            // Determinación dinámica de nombres y claves dependiendo de si es un producto registrado o manual
            'nombre_producto_servicio' => $modelo 
                ? ($modelo->nombre_prestacion ?? $modelo->nombre ?? 'Sin nombre') 
                : ($itemData['nombre'] ?? 'Producto Manual'),
                
            'clave_producto_servicio'=> $modelo 
                ? ($modelo->clave_producto_servicio ?? $modelo->codigo_prestacion ?? 'Sin nombre') 
                : '',
        ]);
    }

    /**
     * Calcula el monto total de un detalle de venta aplicando su porcentaje de IVA correspondiente.
     *
     * @param DetalleVenta $detalle Instancia del detalle procesado.
     * @return float El costo total del item ya con impuestos.
     */
    private function calcularTotalConImpuestos(DetalleVenta $detalle): float
    {
        return $detalle->subtotal + ( $detalle->subtotal * $detalle->iva_aplicado/100);
    }

    /**
     * Actualiza los pagos recibidos de una venta y ajusta su estado (Pagado/Parcial)
     * basándose en si el monto cobrado cubre el total adeudado.
     *
     * @param Venta $venta La venta a la que se le aplica el pago.
     * @param float $montoPagado Cantidad de dinero recibida en esta transacción.
     * @return Venta La venta actualizada con su nuevo estado.
     */
    public function registrarPago(Venta $venta, float $montoPagado): Venta
    {
        $nuevoTotalPagado = $venta->total_pagado + $montoPagado;
        $nuevoEstado = $venta->estado;

        // Regla de negocio: Determinar el estado de la venta según el balance
        if ($nuevoTotalPagado >= $venta->total) {
            $nuevoEstado = Venta::ESTADO_PAGADO; 
        } elseif ($nuevoTotalPagado > 0) {
            $nuevoEstado = Venta::ESTADO_PARCIAL;                   
        }

        $venta->update([
            'total_pagado' => $nuevoTotalPagado,
            'estado'       => $nuevoEstado
        ]);

        return $venta;
    }
}