<?php

namespace App\Services;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ProductoServicio;
use Illuminate\Support\Facades\DB;
use \Exception;

class VentaService
{
    public function crearVenta(array $items, int $estanciaId, int $userId): Venta
    {
        $venta = Venta::create([
            'fecha' => now(),
            'subtotal' => 0,
            'total' => 0,
            'descuento' => 0,
            'estado' => Venta::ESTADO_PENDIENTE,
            'estancia_id' => $estanciaId,
            'user_id' => $userId,
        ]);

        $total = 0;

        foreach ($items as $item) {
            $producto = ProductoServicio::findOrFail($item['id']);
            $cantidad = $item['cantidad'];


            if ($producto->tipo !== 'SERVICIO' && $producto->cantidad >= $cantidad) {
                $producto->decrement('cantidad', $cantidad);
            }

            $detalleVenta = DetalleVenta::create([
                'precio_unitario' => $producto->importe,
                'cantidad' => $cantidad,
                'subtotal' => $producto->importe * $cantidad,
                'estado' => DetalleVenta::ESTADO_PENDIENTE,
                'venta_id' => $venta->id,
                'producto_servicio_id' => $producto->id,
            ]);

            $total += $detalleVenta->subtotal;
        }

        $venta->update([
            'subtotal' => $total,
            'total' => $total * (ProductoServicio::IVA),
        ]);

        return $venta;
    }

    public function addItemToVenta(Venta $venta, array $item): Venta
    {
        $producto = ProductoServicio::findOrFail($item['id']);
        $cantidad = $item['cantidad'];
        
        if ($producto->tipo !== 'SERVICIO' && $producto->cantidad >= $cantidad) {
            $producto->decrement('cantidad', $cantidad);
        }

        $detalleVenta = DetalleVenta::create([
            'precio_unitario' => $producto->importe,
            'cantidad' => $cantidad,
            'subtotal' => $producto->importe * $cantidad,
            'estado' => DetalleVenta::ESTADO_PENDIENTE,
            'venta_id' => $venta->id,
            'producto_servicio_id' => $producto->id,
        ]);

        $nuevoSubtotal = $venta->detalles()->sum('subtotal');
        
        $venta->update([
            'subtotal' => $nuevoSubtotal,
            'total' => $nuevoSubtotal * (ProductoServicio::IVA),
        ]);

        return $venta;
    }
}