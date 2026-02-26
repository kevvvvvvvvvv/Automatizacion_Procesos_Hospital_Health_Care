<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD
=======

/**
 * @property-read \App\Models\Estancia|null $estancia
 * @property-read \App\Models\FormularioInstancia|null $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal query()
 * @mixin \Eloquent
 */
>>>>>>> 2ef01794c18fa32c70560810b695e85dcec8e15b
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