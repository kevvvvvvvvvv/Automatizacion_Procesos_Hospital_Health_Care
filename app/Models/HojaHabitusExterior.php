<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaHabitusExterior extends Model
{
    protected $fillable = [
        'hoja_enfermeria_id',
        'sexo',
        'condicion_llegada',
        'facies',
        'constitucion',
        'postura',
        'piel',
        'estado_conciencia',
        'marcha',
        'movimientos',
        'higiene',
        'edad_aparente',
        'orientacion',
        'lenguaje',
        'olores_ruidos',
    ];

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }
}
