<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $hoja_enfermeria_id
 * @property bool $caidas_previas
 * @property string $estado_mental
 * @property string $deambulacion
 * @property bool $edad_mayor_70
 * @property array<array-key, mixed>|null $medicamentos
 * @property array<array-key, mixed>|null $deficits
 * @property int $puntaje_total
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\HojaEnfermeria $hojaEnfermeria
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereCaidasPrevias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereDeambulacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereDeficits($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereEdadMayor70($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereEstadoMental($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereHojaEnfermeriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereMedicamentos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida wherePuntajeTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaRiesgoCaida whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HojaRiesgoCaida extends Model
{
    protected $fillable = [
        'hoja_enfermeria_id',
        'caidas_previas',
        'estado_mental',
        'deambulacion',
        'edad_mayor_70',
        'medicamentos',
        'deficits',
        'puntaje_total'
    ];

    protected $casts = [
        'medicamentos' =>'array',
        'deficits' => 'array',

        'caidas_previas' => 'boolean',
        'edad_mayor_70' => 'boolean'
    ];

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }
}
