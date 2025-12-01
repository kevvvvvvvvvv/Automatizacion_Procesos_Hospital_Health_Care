<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaGeneral extends Model
{
    protected $timestamp = false;

    protected $fillable = [
        'id',
        'hoja_enfermeria_quirofano_id',
        'hora_inicio_cirugia',
        'hora_inicio_anestesia',
        'hora_inicio_paciente',
        'hora_fin_cirugia',
        'hora_fin_anestesia',
        'hora_fin_paciente'
    ];

    public function hojaEnfermeriaQuirofano(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeriaQuirofano::class);
    }

}
