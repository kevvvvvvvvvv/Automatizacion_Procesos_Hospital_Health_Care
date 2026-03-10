<?php

namespace App\Models\Venta;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pago_id
 * @property int $detalle_venta_id
 * @property string $monto_aplicado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Venta\DetalleVenta $detalleVenta
 * @property-read \App\Models\Venta\Pago|null $pagos
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago whereDetalleVentaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago whereMontoAplicado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago wherePagoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DetallePago whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DetallePago extends Model
{
    protected $fillable = [
        'id',
        'pago_id',
        'detalle_venta_id',
        'monto_aplicado',
    ];

    public function pagos(): BelongsTo
    {
        return $this->belongsTo(Pago::class);
    }

    public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class);
    }   
}
