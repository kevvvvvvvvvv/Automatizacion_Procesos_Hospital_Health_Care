<?php

namespace App\Models\Formulario\NotaEvolucion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\CheckListItem;

/**
 * @property int $id
 * @property string $evolucion_actualizacion
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property int|null $spo2 Saturación de oxígeno en porcentaje (0-100)
 * @property string|null $temp
 * @property string|null $peso
 * @property string|null $talla
 * @property string|null $resultado_estudios
 * @property string|null $resumen_del_interrogatorio
 * @property string|null $exploracion_fisica
 * @property string|null $tratamiento
 * @property string|null $diagnostico_o_problemas_clinicos
 * @property string|null $plan_de_estudio
 * @property string|null $pronostico
 * @property string|null $manejo_dieta
 * @property string|null $manejo_soluciones
 * @property string|null $manejo_medicamentos
 * @property string|null $manejo_laboratorios
 * @property string|null $manejo_medidas_generales
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CheckListItem> $checklistItems
 * @property-read int|null $checklist_items_count
 * @property-read FormularioInstancia $formularioInstancia
 * @property-read mixed $model_type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereEvolucionActualizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereManejoDieta($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereManejoLaboratorios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereManejoMedicamentos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereManejoMedidasGenerales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereManejoSoluciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereSpo2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEvolucion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotaEvolucion extends Model
{
    public const CATALOGO_ID = 12;
    protected $table = 'notas_evoluciones';
    protected $fillable = [
        'id',
        'evolucion_actualizacion',
        'ta',
        'fc',
        'fr',
        'spo2',
        'temp',
        'peso',
        'talla',
        'resultado_estudios',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'tratamiento',

        // Pronóstico
        'pronostico',

        'manejo_dieta',
        'manejo_soluciones',
        'manejo_medicamentos',
        'manejo_laboratorios',
        'manejo_medidas_generales',
        
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function checklistItems(): MorphMany
    {
        return $this->morphMany(CheckListItem::class, 'nota');
    }

    protected $appends = ['model_type'];

    public function getModelTypeAttribute()
    {
        return self::class; 
    }
}
