<?php

namespace App\Models\Formulario\Preoperatoria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;

class Preoperatoria extends Model
{
    public const CATALOGO_ID = 7;

    protected $table = 'preoperatorios';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',

        // Signos vitales
        'ta',
        'fc',
        'fr',
        'peso',
        'talla',
        'temp',

        // Estudios / exploración
        'resultado_estudios',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',

        // Pronóstico
        'pronostico',
        'tratamiento',

        // Datos preoperatorios
        'fecha_cirugia',
        'diagnostico_preoperatorio',
        'plan_quirurgico',
        'tipo_intervencion_quirurgica',
        'riesgo_quirurgico',
        'cuidados_plan_preoperatorios',
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
