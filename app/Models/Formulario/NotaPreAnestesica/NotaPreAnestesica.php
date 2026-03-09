<?php

namespace App\Models\Formulario\NotaPreAnestesica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Formulario\FormularioInstancia;

/**
 * @property int $id
 * @property string|null $ta
 * @property int|null $fc
 * @property int|null $fr
 * @property int|null $spo2 Saturación de oxígeno en porcentaje (0-100)
 * @property string|null $peso
 * @property int|null $talla
 * @property string|null $temp
 * @property string|null $tratamiento
 * @property string|null $resultado_estudios
 * @property string|null $resumen_del_interrogatorio
 * @property string|null $exploracion_fisica
 * @property string|null $diagnostico_o_problemas_clinicos
 * @property string|null $plan_de_estudio
 * @property string|null $pronostico
 * @property string|null $plan_estudios_tratamiento
 * @property string|null $evaluacion_clinica
 * @property string|null $plan_anestesico
 * @property string|null $valoracion_riesgos
 * @property string|null $indicaciones_recomendaciones
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereEvaluacionClinica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereIndicacionesRecomendaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica wherePlanAnestesico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica wherePlanEstudiosTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPreAnestesica whereValoracionRiesgos($value)
 * @mixin \Eloquent
 */
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
