<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    public const ESTADO_PENDIENTE = 'En espera de pago';
    public const ESTADO_PARCIAL = 'Pago parcial';
    public const ESTADO_PAGADO = 'Pagado';
    public const ESTADO_CANCELADO = 'Cancelado';
    
    protected $table = 'detalle_ventas';
    public $incrementing = true;
    protected $fillable = [
        'precio_unitario',
        'cantidad',
        'subtotal',
        'descuento',
        'estado',
        'venta_id',
        'itemable_id',
        'itemable_type',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
