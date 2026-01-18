<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $ta
 * @property int $fc
 * @property int $fr
 * @property float $temp
 * @property float $peso
 * @property int $talla
 * @property string $motivo_atencion
 * @property string $resumen_interrogatorio
 * @property string $exploracion_fisica
 * @property string $estado_mental
 * @property string $resultados_relevantes
 * @property string $diagnostico_problemas_clinicos
 * @property string $tratamiento
 * @property string $pronostico
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereDiagnosticoProblemasClinicos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereEstadoMental($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereExploracionFisica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereFc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereMotivoAtencion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereResultadosRelevantes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereResumenInterrogatorio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereTa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaUrgencia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotaUrgencia extends Model
{
    public const CATALOGO_ID = 9;
    protected $table = 'nota_urgencias';
    protected $fillable = [
        'id',
        'ta',
        'fc',
        'fr',
        'temp',
        'peso',
        'talla',
        'motivo_atencion',
        'resumen_interrogatorio',
        'exploracion_fisica',
        'estado_mental',
        'resultados_relevantes',
        'diagnostico_problemas_clinicos',
        'tratamiento',
        'pronostico',
        
    ];
    
    public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
