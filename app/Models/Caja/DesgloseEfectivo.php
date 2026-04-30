<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $sesion_caja_id
 * @property numeric $denominacion Valor facial de la moneda o billete (ej. 500.00, 20.00, 0.50)
 * @property int $cantidad Cantidad de piezas físicas de esta denominación
 * @property numeric $total Resultado automático de: denominacion * cantidad
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Caja\SesionCaja $sesionCaja
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereCantidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereDenominacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereSesionCajaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DesgloseEfectivo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DesgloseEfectivo extends Model
{
    protected $fillable = [
        'id',
        'sesion_caja_id',
        'denominacion',
        'cantidad',
        'total'
    ];

    public function sesionCaja(): BelongsTo
    {
        return $this->belongsTo(SesionCaja::class);
    }
}
