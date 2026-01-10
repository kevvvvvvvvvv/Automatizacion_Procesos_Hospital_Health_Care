<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
