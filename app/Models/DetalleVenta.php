<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $precio_unitario
 * @property int $cantidad
 * @property string $subtotal
 * @property string|null $descuento
 * @property string $estado
 * @property int $venta_id
 * @property string $itemable_type
 * @property int $itemable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $itemable
 * @property-read \App\Models\Venta $venta
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta wherePrecioUnitario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereVentaId($value)
 * @property string|null $nombre_producto_servicio
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereNombreProductoServicio($value)
 * @mixin \Eloquent
 */
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
