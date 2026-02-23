<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read \App\Models\Estancia|null $estancia
 * @property-read \App\Models\FormularioInstancia|null $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EncuestaPersonal query()
 * @mixin \Eloquent
 */
class EncuestaPersonal extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue la convención plural
    protected $table = 'encuestas_personal';

    protected $fillable = [
        'estancia_id', // Para saber a qué paciente/visita pertenece
        'trato_claro',
        'presentacion_personal',
        'tiempo_atencion',
        'informacion_tratamiento',
        'comentarios',
        'usuario_id' // Quién registró la encuesta
    ];

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}