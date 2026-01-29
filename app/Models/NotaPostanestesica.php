<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property string $diagnostico_o_problemas_clinicos
 * @property string $plan_de_estudio
 * @property string $pronostico
 * @property string $tratamiento
 * @property string $tecnica_anestesica
 * @property string $farmacos_administrados
 * @property string $duracion_anestesia
 * @property string $incidentes_anestesia
 * @property string $balance_hidrico
 * @property string $estado_clinico
 * @property string $plan_manejo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereBalanceHidrico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereDuracionAnestesia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereEstadoClinico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereFarmacosAdministrados($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereIncidentesAnestesia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica wherePlanManejo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereTecnicaAnestesica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaPostanestesica whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotaPostanestesica extends Model
{
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
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',
        'tratamiento',
        'tecnica_anestesica',
        'farmacos_administrados',
        'duracion_anestesia',
        'incidentes_anestesia',
        'balance_hidrico',
        'estado_clinico',
        'plan_manejo',
    ];

    
    public function formularioInstancia():BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
