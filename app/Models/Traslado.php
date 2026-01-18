<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property string $peso
 * @property int $talla
 * @property string $temp
 * @property string $resultado_estudios
 * @property string $tratamiento
 * @property string $resumen_del_interrogatorio
 * @property string $exploracion_fisica
 * @property string $diagnostico_o_problemas_clinicos
 * @property string $plan_de_estudio
 * @property string $pronostico
 * @property string $unidad_medica_envia
 * @property string $unidad_medica_recibe
 * @property string $motivo_translado
 * @property string $impresion_diagnostica
 * @property string $terapeutica_empleada
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereDiagnosticoOProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereImpresionDiagnostica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereMotivoTranslado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado wherePlanDeEstudio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereResultadoEstudios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereResumenDelInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereTerapeuticaEmpleada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereUnidadMedicaEnvia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereUnidadMedicaRecibe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Traslado whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Traslado extends Model
{
    public const CATALOGO_ID = 6;
    protected $table = 'traslado';
    protected $fillable = [
        'id',
         'id',
        'ta',
        'fc',
        'fr',
        'peso',
        'talla',
        'temp',
        'resultado_estudios',
        'tratamiento',
        'resumen_del_interrogatorio',
        'exploracion_fisica',
        'diagnostico_o_problemas_clinicos',
        'plan_de_estudio',
        'pronostico',
        'unidad_medica_envia',
        'unidad_medica_recibe',
        'motivo_translado',
        'impresion_diagnostica',
        'terapeutica_empleada',
    ];
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
    
}
