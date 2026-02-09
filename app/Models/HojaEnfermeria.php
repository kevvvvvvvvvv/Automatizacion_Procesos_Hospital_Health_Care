<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int $id
 * @property string $turno
 * @property string|null $observaciones
 * @property string|null $habitus_exterior
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FormularioInstancia $formularioInstancia
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaControlLiquido> $hojaControlLiquidos
 * @property-read int|null $hoja_control_liquidos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaEscalaValoracion> $hojaEscalaValoraciones
 * @property-read int|null $hoja_escala_valoraciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaHabitusExterior> $hojaHabitusExterior
 * @property-read int|null $hoja_habitus_exterior_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaMedicamento> $hojaMedicamentos
 * @property-read int|null $hoja_medicamentos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaOxigeno> $hojaOxigenos
 * @property-read int|null $hoja_oxigenos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaRiesgoCaida> $hojaRiesgoCaida
 * @property-read int|null $hoja_riesgo_caida_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaSignos> $hojaSignos
 * @property-read int|null $hoja_signos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaTerapiaIV> $hojasTerapiaIV
 * @property-read int|null $hojas_terapia_i_v_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudDieta> $solicitudesDieta
 * @property-read int|null $solicitudes_dieta_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudEstudio> $solicitudesEstudio
 * @property-read int|null $solicitudes_estudio_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\HojaSondaCateter> $sondasCateteres
 * @property-read int|null $sondas_cateteres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereHabitusExterior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereObservaciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereTurno($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HojaEnfermeria whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SolicitudPatologia> $solicitudPatologia
 * @property-read int|null $solicitud_patologia_count
 * @mixin \Eloquent
 */
class HojaEnfermeria extends Model
{
    protected $table = 'hoja_enfermerias';
    
    protected $fillable = [
        'id',
        'turno',
        'observaciones',
        'habitus_exterior',
        'estado',
    ];

    protected $cast = [
        'habitus_exterior' => 'array'
    ];

    public $incrementing = false;

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function hojaMedicamentos(): HasMany
    {
        return $this->hasMany(HojaMedicamento::class);
    }

    public function hojasTerapiaIV(): HasMany
    {
        return $this->hasMany(HojaTerapiaIV::class);
    }

    public function hojaSignos():HasMany
    {
        return $this->hasMany(HojaSignos::class);
    }

    public function hojaControlLiquidos(): HasMany
    {
        return $this->hasMany(HojaControlLiquido::class);
    }

    public function hojaEscalaValoraciones(): HasMany
    {
        return $this->hasMany(HojaEscalaValoracion::class);
    }

    public function hojaRiesgoCaida(): HasMany
    {
        return $this->hasMany(HojaRiesgoCaida::class);
    }

    public function hojaHabitusExterior(): HasMany
    {
        return $this->hasMany(HojaHabitusExterior::class);
    }

    public function hojaOxigenos(): MorphMany
    {
        return $this->morphMany(HojaOxigeno::class,'itemable');
    }

    public function solicitudesDieta(): HasMany
    {
        return $this->hasMany(SolicitudDieta::class);
    }

    public function solicitudesEstudio(): MorphMany
    {
        return $this->morphMany(SolicitudEstudio::class, 'itemable');
    }

    public function sondasCateteres(): HasMany
    {
        return $this->hasMany(HojaSondaCateter::class);
    }

    public function solicitudPatologia(): MorphMany
    {
        return $this->morphMany(SolicitudPatologia::class,'itemable');
    }
}
