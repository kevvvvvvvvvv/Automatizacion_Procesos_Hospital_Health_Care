<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $isquemiable_type
 * @property int $isquemiable_id
 * @property string $sitio_anatomico
 * @property \Illuminate\Support\Carbon|null $hora_inicio
 * @property \Illuminate\Support\Carbon|null $hora_termino
 * @property string|null $observaciones
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $isquemiable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereHoraTermino($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereIsquemiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereIsquemiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereSitioAnatomico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Isquemia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Isquemia extends Model
{
    protected $fillable = [
        'id',
        'isquemiable_type',
        'isquemiable_id',
        'sitio_anatomico',
        'hora_inicio',
        'hora_termino',
        'observaciones',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:Y-m-d\TH:i:sP',
        'hora_termino' => 'datetime:Y-m-d\TH:i:sP',
    ];

    public function isquemiable(): MorphTo
    {
        return $this->morphTo();
    }
}
