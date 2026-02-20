<?php

namespace App\Services;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ProductoServicio;
use App\Models\CatalogoEstudio;
use Illuminate\Support\Facades\DB;
use Exception;

class VentaService
{
    /**
     * Crea una venta completa desde cero
     * @param array $items  Debe ser array de: ['id' => 1, 'cantidad' => 2, 'tipo' => 'producto'|'estudio']
     */
    public function crearVenta(array $items, int $estanciaId, int $userId): Venta
    {
        return DB::transaction(function () use ($items, $estanciaId, $userId) {

            $venta = Venta::create([
                'fecha' => now(),
                'subtotal' => 0,
                'total' => 0,
                'descuento' => 0,
                'estado' => Venta::ESTADO_PENDIENTE,
                'estancia_id' => $estanciaId,
                'user_id' => $userId,
            ]);

            $subtotalAcumulado = 0;
            $totalAcumulado = 0;

            
            foreach ($items as $item) {
                $detalle = $this->procesarItem($venta, $item);
                $subtotalAcumulado += $detalle->subtotal;
                $totalAcumulado += $this->calcularTotalConImpuestos($detalle);
            }

            $venta->update([
                'subtotal' => $subtotalAcumulado,
                'total' => $totalAcumulado,
            ]);

            return $venta;
        });
    }

    public function addItemToVenta(Venta $venta, array $item): Venta
    {
        return DB::transaction(function () use ($venta, $item) {
            
            $detalle = $this->procesarItem($venta, $item);

            $nuevoSubtotal = $venta->detalles()->sum('subtotal');
            
            $totalNuevoItem = $this->calcularTotalConImpuestos($detalle);
            $nuevoTotalVenta = $venta->total + $totalNuevoItem;

            $venta->update([
                'subtotal' => $nuevoSubtotal,
                'total' => $nuevoTotalVenta,
            ]);

            return $venta;
        });
    }

    /**
     * Lógica central para determinar si es Producto o Estudio y guardarlo
     */
    private function procesarItem(Venta $venta, array $itemData): DetalleVenta
    {
        $id = $itemData['id'];
        $cantidad = $itemData['cantidad'];
        $tipo = $itemData['tipo']; 

        $modelo = null;
        // Buscamos el precio y el nombre que vengan en el request por si el producto no existe
        $precioUnitario = $itemData['precio'] ?? 0.1; 
        $iva = $itemData['iva'] ?? 0;

        if ($tipo === 'producto') {
            $modelo = ProductoServicio::find($id);
            
            if ($modelo) {
                $precioUnitario = $modelo->importe ?? $precioUnitario;
                $iva = $modelo->iva ?? $iva;

                // Solo descontamos stock si el modelo existe y no es servicio
                if ($modelo->tipo !== 'SERVICIOS') {
                    // Si hay stock lo descontamos, si no, lo dejamos pasar (ya que quieres permitir la venta)
                    if ($modelo->cantidad >= $cantidad) {
                        $modelo->decrement('cantidad', $cantidad);
                    }
                }
            }
        } 
        
        elseif ($tipo === 'estudio') {
            $modelo = CatalogoEstudio::find($id);
            
            if ($modelo) {
                $precioUnitario = $modelo->costo;
                $iva = 0;
            }
        }

        return DetalleVenta::create([
            'venta_id'      => $venta->id,
            'itemable_id'   => $modelo ? $modelo->id : null,          
            'itemable_type' => $modelo ? get_class($modelo) : null,  
            'precio_unitario' => $precioUnitario,
            'cantidad'      => $cantidad,
            'subtotal'      => $precioUnitario * $cantidad,
            'estado'        => 'completado',

            'nombre_producto_servicio' => $modelo 
                ? ($modelo->nombre_prestacion ?? $modelo->nombre ?? 'Sin nombre') 
                : ($itemData['nombre'] ?? 'Producto Manual'),
                
            'clave_producto_servicio'=> $modelo 
                ? ($modelo->clave_producto_servicio ?? $modelo->codigo_prestacion ?? 'Sin nombre') 
                : ($itemData['nombre'] ?? 'Producto Manual'),
                
            'iva_aplicado'   => $iva,
        ]);
    }

    /**
     * Helper para calcular el precio final con IVA
     */
    private function calcularTotalConImpuestos(DetalleVenta $detalle)
    {
        $item = $detalle->itemable ?? '';
        $iva = 0;

        if ($item instanceof ProductoServicio) {
            $iva = $item->iva ?? 0;
        } 
        
        return $detalle->subtotal * (1 + ($iva / 100));
    }


    public function registrarPago(Venta $venta, float $montoPagado)
    {
        $nuevoTotalPagado = $venta->total_pagado + $montoPagado;
        
        $nuevoEstado = $venta->estado;

        if ($nuevoTotalPagado >= $venta->total) {
            $nuevoEstado = Venta::ESTADO_PAGADO; 
        } elseif ($nuevoTotalPagado > 0) {
            $nuevoEstado = Venta::ESTADO_PARCIAL;                   
        }

        $venta->update([
            'total_pagado' => $nuevoTotalPagado,
            'estado' => $nuevoEstado
        ]);

        return $venta;
    }
}