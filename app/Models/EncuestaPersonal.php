<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class EncuestaPersonal extends Model
{
    protected $table = 'encuesta_personal'; // Asegúrate que coincida con la migración

    // 1. IMPORTANTE: Dile a Laravel que el ID no es autoincremental
    public $incrementing = false;

    // 2. IMPORTANTE: Permite que el 'id' se guarde manualmente
    protected $fillable = [
        'id', 
        'trato_claro', 
        'presentacion_personal', 
        'tiempo_atencion', 
        'informacion_tratamiento', 
        'comentarios'
    ];
}