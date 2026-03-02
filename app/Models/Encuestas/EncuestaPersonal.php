<?php

namespace App\Models\Encuestas;

use Illuminate\Database\Eloquent\Model;

class EncuestaPersonal extends Model
{
    protected $table = 'encuesta_personal'; 
    public $incrementing = false;

    protected $fillable = [
        'id', 
        'trato_claro', 
        'presentacion_personal', 
        'tiempo_atencion', 
        'informacion_tratamiento', 
        'comentarios'
    ];
}
