<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    public $incrementing = true;
    protected $fillable = [
        'precio_unitario',
        'cantidad',
        'subtotal',
        'descuento',
        'estado',
        'venta_id',
        'producto_servicio_id',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }
}
