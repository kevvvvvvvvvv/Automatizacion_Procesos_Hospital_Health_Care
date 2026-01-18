<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $fecha_cirugia
 * @property string $diagnostico_preoperatorio
 * @property string $plan_quirurgico
 * @property string $tipo_intervencion_quirurgica
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property string $peso
 * @property int $talla
 * @property string $temp
 * @property string $resultado_estudios
 * @property string $resumen_del_interrogatorio
 * @property string $exploracion_fisica
 * @property string $diagnostico_o_problemas_clinicos
 * @property string $plan_de_estudio
 * @property string $pronostico
 * @property string $tratamiento
 * @property string $riesgo_quirurgico
 * @property string $cuidados_plan_preoperatorios
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereCuidadosPlanPreoperatorios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereDiagnosticoPreoperatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereFechaCirugia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria wherePlanQuirurgico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereRiesgoQuirurgico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereTipoIntervencionQuirurgica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Preoperatoria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}

