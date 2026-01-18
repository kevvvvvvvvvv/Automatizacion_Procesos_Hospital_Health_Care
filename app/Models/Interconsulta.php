<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $criterio_diagnostico
 * @property string $plan_de_estudio
 * @property string $sugerencia_diagnostica
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property string $temp
 * @property string $peso
 * @property int $talla
 * @property string $motivo_de_la_atencion_o_interconsulta
 * @property string $resumen_del_interrogatorio
 * @property string $exploracion_fisica
 * @property string $estado_mental
 * @property string $resultados_relevantes_del_estudio_diagnostico
 * @property string $diagnostico_o_problemas_clinicos
 * @property string $tratamiento
 * @property string $pronostico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Honorario> $honorarios
 * @property-read int|null $honorarios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereCriterioDiagnostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereEstadoMental($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereMotivoDeLaAtencionOInterconsulta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereResultadosRelevantesDelEstudioDiagnostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereSugerenciaDiagnostica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Interconsulta whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Interconsulta extends Model
{
    protected $table = 'interconsultas';
     protected $fillable = [
        'id',
        'ta', 'fc', 'fr', 'temp', 'peso', 'talla',
       'criterio_diagnostico', 'plan_de_estudio', 'sugerencia_diagnostica',
       'motivo_de_la_atencion_o_interconsulta', 'resumen_del_interrogatorio',
       'exploracion_fisica', 'estado_mental', 'resultados_relevantes_del_estudio_diagnostico',
       'diagnostico_o_problemas_clinicos', 'tratamiento','pronostico',
   ];


    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }
    public function honorarios()
    {
        return $this->hasMany(Honorario::class);
    }

   
}
