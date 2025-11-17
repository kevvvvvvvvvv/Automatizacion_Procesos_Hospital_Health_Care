<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotaPostanestesica extends Model
{
    protected $fillable = [
        'id',
        'tension_arterial',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'temperatura',
        'peso',
        'talla',
        'resumen_integarrogatorio',
        'exploracion_fisica',
        'resultados_estudios',
        'diagnosticos_problemas',
        'pronostico',
        'plan_estudio_tratamiento',
        'evaluacion',
        'plan_anestesico',
        'valoracion_riesgo',
        'indicaciones_recomendaciones',
    ];

    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
