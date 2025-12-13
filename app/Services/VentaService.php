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
            
            // 1. Procesamos y guardamos el nuevo detalle
            $detalle = $this->procesarItem($venta, $item);

            // 2. Recalculamos los totales de la venta sumando lo que ya había + lo nuevo
            // Ojo: Es más seguro sumar desde la BD para evitar errores de desincronización
            $nuevoSubtotal = $venta->detalles()->sum('subtotal');
            
            // Para el total con impuestos, es mejor iterar o guardar el total con impuestos en el detalle
            // Aquí usaré una lógica simple sumando al total anterior:
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
        $precioUnitario = 0;
        $iva = 0;

        if ($tipo === 'producto') {
            $modelo = ProductoServicio::findOrFail($id);
            $precioUnitario = $modelo->importe;
            $iva = $modelo->iva ?? 16;
            if ($modelo->tipo !== 'SERVICIOS') {
                if ($modelo->cantidad < $cantidad) {
                    throw new Exception("Stock insuficiente para el producto: {$modelo->nombre_prestacion}");
                }
                $modelo->decrement('cantidad', $cantidad);
            }
        } 
        
        elseif ($tipo === 'estudio') {
            $modelo = CatalogoEstudio::findOrFail($id);
            $precioUnitario = $modelo->costo; 
            $iva = 0;
        } 
        
        else {
            throw new Exception("Tipo de item no válido: $tipo");
        }

        return DetalleVenta::create([
            'venta_id' => $venta->id,
            'itemable_id' => $modelo->id,          
            'itemable_type' => get_class($modelo),  
            'precio_unitario' => $precioUnitario,
            'cantidad' => $cantidad,
            'subtotal' => $precioUnitario * $cantidad,
            'estado' => 'completado', // O 'pendiente' según tu lógica
            // Sugerencia: Guarda el IVA histórico en el detalle por si cambian los impuestos mañana
            // 'iva_aplicado' => $iva 
        ]);
    }

    /**
     * Helper para calcular el precio final con IVA
     */
    private function calcularTotalConImpuestos(DetalleVenta $detalle)
    {
        $item = $detalle->itemable;
        $iva = 0;

        if ($item instanceof ProductoServicio) {
            $iva = $item->iva;
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