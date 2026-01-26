<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $padecimiento_actual
 * @property string $tension_arterial
 * @property int $frecuencia_cardiaca
 * @property int $frecuencia_respiratoria
 * @property float $temperatura
 * @property float $peso
 * @property int $talla
 * @property string $resultados_previos
 * @property string $diagnostico
 * @property string $pronostico
 * @property string $indicacion_terapeutica
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RespuestaFormulario> $respuestaFormularios
 * @property-read int|null $respuesta_formularios_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereDiagnostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereFrecuenciaCardiaca($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereFrecuenciaRespiratoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereIndicacionTerapeutica($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica wherePadecimientoActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica wherePeso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica wherePronostico($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereResultadosPrevios($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereTalla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereTemperatura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HistoriaClinica whereTensionArterial($value)
 * @mixin \Eloquent
 */
class HistoriaClinica extends Model
{
    protected $table ='historia_clinicas';

    public $incrementing = false;
    protected $fillable = [
        'id',
        'padecimiento_actual',
        'tension_arterial',
        'frecuencia_cardiaca',
        'frecuencia_respiratoria',
        'saturacion_oxigeno',
        'temperatura',
        'peso',
        'talla',
        'resultados_previos',
        'diagnostico',
        'pronostico',
        'indicacion_terapeutica',
    ];

    public $timestamps = false;

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id','id');
    }

    public function respuestaFormularios(): HasMany
    {
        return $this->hasMany(RespuestaFormulario::class,'historia_clinica_id');
    }
}
