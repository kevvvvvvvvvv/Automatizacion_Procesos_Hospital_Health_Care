<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property float $temp
 * @property float $peso
 * @property int $talla
 * @property string $resumen_del_interrogatorio
 * @property string $exploracion_fisica
 * @property string $resultado_estudios
 * @property string $tratamiento
 * @property string $diagnostico_o_problemas_clinicos
 * @property string $plan_de_estudio
 * @property string $pronostico
 * @property string $hora_inicio_operacion
 * @property string $hora_termino_operacion
 * @property string $diagnostico_preoperatorio
 * @property string $operacion_planeada
 * @property string $operacion_realizada
 * @property string $diagnostico_postoperatorio
 * @property string $descripcion_tecnica_quirurgica
 * @property string $hallazgos_transoperatorios
 * @property string $reporte_conteo
 * @property string $incidentes_accidentes
 * @property string $cuantificacion_sangrado
 * @property string $estado_postquirurgico
 * @property string|null $manejo_dieta
 * @property string|null $manejo_soluciones
 * @property string|null $manejo_medicamentos
 * @property string|null $manejo_medidas_generales
 * @property string|null $manejo_laboratorios
 * @property string $hallazgos_importancia
 * @property int|null $solicitud_patologia_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CheckListItem> $checklistItems
 * @property-read int|null $checklist_items_count
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read mixed $model_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalEmpleado> $personalEmpleados
 * @property-read int|null $personal_empleados_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TransfusionRealizada> $transfusiones
 * @property-read int|null $transfusiones_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereCuantificacionSangrado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereDescripcionTecnicaQuirurgica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereDiagnosticoPostoperatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereDiagnosticoPreoperatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereEstadoPostquirurgico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereHallazgosImportancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereHallazgosTransoperatorios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereHoraInicioOperacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereHoraTerminoOperacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereIncidentesAccidentes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereManejoDieta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereManejoLaboratorios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereManejoMedicamentos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereManejoMedidasGenerales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereManejoSoluciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereOperacionPlaneada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereOperacionRealizada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereReporteConteo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereSolicitudPatologiaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostoperatoria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotaPostoperatoria extends Model
{
    public const ID_CATALOGO = 8;

    public $incrementing = false;

    protected $fillable = [
        'id',

        'ta',   
        'fc',   
        'fr',    
        'temp', 
        'peso',   
        'talla',  
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'resultado_estudios',
        'tratamiento',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',

        'hora_inicio_operacion',
        'hora_termino_operacion',
        'diagnostico_preoperatorio', 
        'operacion_planeada',
        'operacion_realizada',
        'diagnostico_postoperatorio',
        'descripcion_tecnica_quirurgica',
        'hallazgos_transoperatorios',
        'reporte_conteo',
        'incidentes_accidentes',
        'cuantificacion_sangrado',
        'estado_postquirurgico',

        'manejo_dieta',
        'manejo_soluciones',
        'manejo_medicamentos',
        'manejo_medidas_generales',
        'manejo_laboratorios',
        
        'pronostico',
        //'envio_piezas',
        'hallazgos_importancia',
        'solicitud_patologia_id',
    ];


    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    /*public function personalEmpleados(): HasMany
    {
        return $this->hasMany(PersonalEmpleado::class, 'nota_postoperatoria_id', 'id');
    }*/

    public function transfusiones(): HasMany
    {
        return $this->hasMany(TransfusionRealizada::class, 'nota_postoperatoria_id', 'id');
    }

    public function personalEmpleados()
    {
        return $this->morphMany(PersonalEmpleado::class, 'itemable');
    }

    public function checklistItems()
    {
        return $this->morphMany(CheckListItem::class, 'nota');
    }

    protected $appends = ['model_type'];

    public function getModelTypeAttribute()
    {
        return self::class; 
    }
}
