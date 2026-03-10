<?php

namespace App\Services;

use App\Models\Venta\Venta;
use App\Models\Venta\DetalleVenta;
use App\Models\Inventario\ProductoServicio;
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Venta\MetodoPago;

use Illuminate\Support\Facades\DB;
use Exception;
use Stripe\Product;

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
        $precioUnitario = $itemData['precio'] ?? 0.1; 
        $iva = $itemData['iva'] ?? 0;

        if ($tipo === 'producto') {
            $modelo = ProductoServicio::find($id);
            
            if ($modelo) {
                $precioUnitario = $modelo->importe ?? $precioUnitario;
                $iva = $modelo->iva ?? $iva;

                if ($modelo->tipo !== 'SERVICIOS') {
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
                $iva = $precioUnitario * .16;
            }
        }

        return DetalleVenta::create([
             'venta_id'      => $venta->id,
                'itemable_id'   => $modelo ? $modelo->id : null,          
                'itemable_type' => $modelo ? get_class($modelo) : null,  
                'precio_unitario' => $precioUnitario * 1.04176, //colocar formular
                'cantidad'      => $cantidad, 
                'subtotal'      => ($precioUnitario * 1.04176) * $cantidad, // colocar formular
                'estado'        => 'completado',

            'nombre_producto_servicio' => $modelo 
                ? ($modelo->nombre_prestacion ?? $modelo->nombre ?? 'Sin nombre') 
                : ($itemData['nombre'] ?? 'Producto Manual'),
                
            'clave_producto_servicio'=> $modelo 
                ? ($modelo->clave_producto_servicio ?? $modelo->codigo_prestacion ?? 'Sin nombre') 
                : ($itemData['nombre'] ?? 'Producto Manual'),
                
            'iva_aplicado'   => $iva = $precioUnitario * .16,
        ]);

    }

    /**
     * Helper para calcular el precio del producto con la comision de la terminal
     */
/*
    private function calcularComisionTerminal(DetalleVenta $detalle)
    {
        $item = $detalle->itemable ?? '';
        return ($item->subtotal/);
    }
*/


    /**
     * Helper para calcular el precio final con IVA
     */
    private function calcularTotalConImpuestos(DetalleVenta $detalle)
    {
        $item = $detalle->itemable ?? '';
        $iva = 0;

        if ($item instanceof ProductoServicio) {
<<<<<<< HEAD
            $iva = $item->iva ?? 0;
=======
            $iva = $item->iva ?? 16;
>>>>>>> c177e047d41177b143652ce1b25f49a8769f8f63
        } 
        
        return $detalle->subtotal * (1 + ($iva / 100));
    }
<<<<<<< HEAD
   
=======

    private function calcularTotalTarjeta(DetalleVenta $venta)
    {
        $item = $detalle-> itemable ?? '';
            
    }
>>>>>>> c177e047d41177b143652ce1b25f49a8769f8f63


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