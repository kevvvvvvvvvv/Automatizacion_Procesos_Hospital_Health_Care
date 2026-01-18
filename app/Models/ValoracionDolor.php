<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $escala_eva
 * @property string|null $ubicacion_dolor
 * @property int $hoja_escala_valoracion_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEscalaValoracion $hojaEscalaValoracion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereEscalaEva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereHojaEscalaValoracionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereUbicacionDolor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ValoracionDolor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ValoracionDolor extends Model
{
    protected $fillable = [
        'escala_eva',
        'ubicacion_dolor',

        'hoja_escala_valoracion_id'
    ];

    public function hojaEscalaValoracion(): BelongsTo
    {
        return $this->belongsTo(HojaEscalaValoracion::class);
    }
}
