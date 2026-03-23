<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property int $id
 * @property string|null $nombre_producto_servicio
 * @property string|null $clave_producto_servicio
 * @property string $precio_unitario
 * @property int $cantidad
 * @property string $subtotal
 * @property string|null $descuento
 * @property string $estado
 * @property string $iva_aplicado
 * @property string $monto_pagado
 * @property int $venta_id
 * @property string|null $itemable_type
 * @property int|null $itemable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Venta\DetallePago> $detallePagos
 * @property-read int|null $detalle_pagos_count
 * @property-read Model|\Eloquent|null $itemable
 * @property-read \App\Models\Venta\Venta $venta
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereClaveProductoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereItemableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereItemableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereIvaAplicado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereMontoPagado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereNombreProductoServicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta wherePrecioUnitario($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetalleVenta whereVentaId($value)
 * @property-read mixed $monto_iva
 * @property-read mixed $saldo_pendiente
 * @property-read mixed $total_facturado
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
        'iva_aplicado', //IVA historico
        'venta_id',
        'monto pagado',

        'itemable_id',
        'itemable_type',
        'nombre_producto_servicio',
        'clave_producto_servicio',
    ];

    protected $appends = [
        'monto_iva',
        'total_facturado',
        'saldo_pendiente', 
    ];


    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function detallePagos(): HasMany
    {
        return $this->hasMany(DetallePago::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    public function getMontoIvaAttribute()
    {
        // Calcula el monto del IVA basado en el porcentaje de la base de datos
        return ($this->subtotal * ($this->iva_aplicado / 100));
    }

    public function getTotalFacturadoAttribute()
    {
        // El precio final (Base + IVA)
        return $this->subtotal + $this->monto_iva;
    }

    public function getSaldoPendienteAttribute()
    {
        $descuento = $this->descuento ?? 0;
        $montoPagado = $this->monto_pagado ?? 0; 
        
        return round(($this->total_facturado - $descuento) - $montoPagado, 2);
    }

}
