<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaSignos extends Model
{
    protected $table = 'hoja_registros';
    
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'fecha_hora_registro',
        'tension_arterial_sistolica',
        'tension_arterial_diastolica',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'temperatura',
        'saturacion_oxigeno',
        'glucemia_capilar',
        'talla',
        'peso',
        'uresis',
        'uresis_descripcion',
        'evacuaciones',
        'evacuaciones_descripcion',
        'emesis',
        'emesis_descripcion',
        'drenes',
        'drenes_descripcion',
        'estado_conciencia',
        'escala_braden',
        'escala_glasgow',
        'escala_eva',
    ];

    public function hojaEnfermeria():BelongsTo
    {   
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }
}
