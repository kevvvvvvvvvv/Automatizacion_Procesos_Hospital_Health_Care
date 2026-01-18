<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $motivo_egreso
 * @property string $diagnosticos_finales
 * @property string $resumen_evolucion_estado_actual
 * @property string $manejo_durante_estancia
 * @property string $problemas_pendientes
 * @property string $plan_manejo_tratamiento
 * @property string $recomendaciones
 * @property string $factores_riesgo
 * @property string $pronostico
 * @property string|null $defuncion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereDefuncion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereDiagnosticosFinales($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereFactoresRiesgo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereManejoDuranteEstancia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereMotivoEgreso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso wherePlanManejoTratamiento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereProblemasPendientes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereRecomendaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereResumenEvolucionEstadoActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NotaEgreso whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotaEgreso extends Model
{
     public const CATALOGO_ID = 11;
    protected $table = 'nota_egresos';
    protected $fillable = [
        'id',
        'motivo_egreso',
        'diagnosticos_finales',
        'resumen_evolucion_estado_actual',
        'manejo_durante_estancia',
        'problemas_pendientes',
        'plan_manejo_tratamiento',
        'recomendaciones',
        'factores_riesgo',
        'pronostico',
        'defuncion',
    ];
      public function formularioInstancia()
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }
}
