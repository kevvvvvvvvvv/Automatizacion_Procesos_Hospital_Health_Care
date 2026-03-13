<?php

namespace App\Models\Venta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;
use App\Models\Venta\Venta;

/**
 * @property int $id
 * @property int $venta_id
 * @property int $metodo_pago_id
 * @property string $monto
 * @property string|null $referencia
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Venta\MetodoPago $metodoPago
 * @property-read User $user
 * @property-read Venta $venta
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMetodoPagoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereReferencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereVentaId($value)
 * @property string $folio
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Venta\DetallePago> $detalles
 * @property-read int|null $detalles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereFolio($value)
 * @property string|null $monto_ingresado
 * @property string|null $cambio_dispensado
 * @property string $monto_restante
 * @property string|null $clave_cajero
 * @property array<array-key, mixed>|null $metadata_cajero
 * @property-read float $iva_ventas
 * @property-read float $subtotal_ventas
 * @property-read float $total_ventas
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereCambioDispensado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereClaveCajero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMetadataCajero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMontoIngresado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMontoRestante($value)
 * @mixin \Eloquent
 */
class Pago extends Model
{
    protected $fillable = [
        'id',
        'folio',
        'venta_id',
        'metodo_pago_id',
        'monto',
        'monto_restante',
        'referencia',
        'user_id',
        'monto_ingresado',
        'cambio_dispensado',
        'clave_cajero',
        'requiere_factura',
        'metadata_cajero',
    ];

    protected $casts = [
        'metadata_cajero' => 'array',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePago::class); 
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }

    protected $appends = [
        'subtotal_ventas',
        'iva_ventas',
        'total_ventas',
    ];

    /**
     * Suma los subtotales de los DetalleVenta vinculados a este pago
     */
    public function getSubtotalVentasAttribute(): float
    {
        return (float) $this->detalles->sum(function ($detallePago) {
            // Entramos a la relación para traer el subtotal del producto/servicio
            return $detallePago->detalleVenta->subtotal;
        });
    }

    /**
     * Calcula el IVA total sumando el IVA de cada DetalleVenta vinculado
     */
    public function getIvaVentasAttribute(): float
    {
        return (float) $this->detalles->sum(function ($detallePago) {
            $dv = $detallePago->detalleVenta;
            $porcentajeIva = $dv->iva ?? 16; 
            return $dv->subtotal * ($porcentajeIva / 100);
        });
    }

    /**
     * Suma el Subtotal + IVA calculados arriba
     */
    public function getTotalVentasAttribute(): float
    {
        return $this->subtotal_ventas + $this->iva_ventas;
    }

}
