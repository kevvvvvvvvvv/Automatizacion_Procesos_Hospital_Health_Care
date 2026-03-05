<?php

namespace App\Models\Formulario\NotaPreAnestesica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;

class NotaPreAnestesica extends Model
{
    public const CATALOGO_ID = 12; 

    protected $table = 'nota_pre_anestesicas';

    protected $fillable = [
        'id',
        'ta',
        'fc',
        'fr',
        'spo2',
        'peso',
        'talla',
        'temp',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'resultado_estudios',
        'tratamiento',
        'plan_de_estudio',
        'pronostico',
        'plan_estudios_tratamiento',
        'evaluacion_clinica',
        'plan_anestesico',
        'valoracion_riesgos',
        'indicaciones_recomendaciones',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
