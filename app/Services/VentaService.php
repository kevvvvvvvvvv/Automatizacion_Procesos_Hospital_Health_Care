<?php

namespace App\Services;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ProductoServicio;
use Illuminate\Support\Facades\DB;
use \Exception;

class VentaService
{
    /**
     * Crea una Venta y sus detalles a partir de una lista de items.
     * Esta función ASUME que está dentro de una transacción de BD.
     *
     * @param array $items - Array de items (ej: [['id' => 1, 'cantidad' => 2], ...])
     * @param int $estanciaId - ID de la estancia para asociar la venta
     * @param int $userId - ID del usuario que crea la venta
     * @return Venta - La venta creada
     * @throws \Exception - Si no hay stock para un producto
     */
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

            if ($producto->tipo === 'INSUMOS') { 
                if ($cantidad > $producto->cantidad) {
                    throw new Exception('No hay cantidad suficiente del producto: ' . $producto->nombre_prestacion);
                }
                $producto->decrement('cantidad', $cantidad);
            }

            $detalleVenta = DetalleVenta::create([
                'precio_unitario' => $producto->importe,
                'cantidad' => $cantidad,
                'subtotal' => $producto->importe * $cantidad,
                'descuento' => 0,
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
}