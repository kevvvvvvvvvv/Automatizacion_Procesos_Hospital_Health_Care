<?php

namespace App\Models\Formulario\HojaEnfermeria;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\HojaOxigeno;
use App\Models\Estudio\SolicitudEstudio;
use App\Models\Estudio\SolicitudPatologia;

/**
 * @property int $id
 * @property string $turno
 * @property string|null $observaciones
 * @property string|null $habitus_exterior
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read FormularioInstancia $formularioInstancia
 * @property-read mixed $sondas_activas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaControlLiquido> $hojaControlLiquidos
 * @property-read int|null $hoja_control_liquidos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaEscalaValoracion> $hojaEscalaValoraciones
 * @property-read int|null $hoja_escala_valoraciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaHabitusExterior> $hojaHabitusExterior
 * @property-read int|null $hoja_habitus_exterior_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaMedicamento> $hojaMedicamentos
 * @property-read int|null $hoja_medicamentos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, HojaOxigeno> $hojaOxigenos
 * @property-read int|null $hoja_oxigenos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaRiesgoCaida> $hojaRiesgoCaida
 * @property-read int|null $hoja_riesgo_caida_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaSignos> $hojaSignos
 * @property-read int|null $hoja_signos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV> $hojasTerapiaIV
 * @property-read int|null $hojas_terapia_i_v_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SolicitudPatologia> $solicitudPatologia
 * @property-read int|null $solicitud_patologia_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\SolicitudDieta> $solicitudesDieta
 * @property-read int|null $solicitudes_dieta_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SolicitudEstudio> $solicitudesEstudio
 * @property-read int|null $solicitudes_estudio_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Formulario\HojaEnfermeria\HojaSondaCateter> $sondasCateteres
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

    protected $appends = [
        'oxigeno_activo'
    ];

    public $incrementing = false;

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function hojaMedicamentos(): MorphMany
{
    return $this->morphMany(HojaMedicamento::class, 'medicable');
    }

    public function hojasTerapiaIV(): MorphMany
    {
    return $this->morphMany(HojaTerapiaIV::class, 'terapiable');
    }

    public function hojaSignos():MorphMany
    {
    return $this->morphMany(HojaSignos::class, 'registrable');
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

    public function getSondasActivasAttribute()
    {
        $sondasActuales = $this->sondasCateteres;
        $estanciaId = $this->formularioInstancia->estancia_id;

        $sondasHeredadas = HojaSondaCateter::whereHas('hojaEnfermeria', function ($query) use ($estanciaId) {
            $query->where('id', '<', $this->id)
                  ->whereHas('formularioInstancia', function ($q) use ($estanciaId) {
                      $q->where('estancia_id', $estanciaId);
                  });
        })
        ->where(function($query) {
            $query->whereNull('fecha_caducidad')
                  ->orWhere('fecha_caducidad', '>=', $this->created_at);
        })
        ->get();

        return $sondasActuales->merge($sondasHeredadas);
    }

    public function getOxigenoActivoAttribute()
    {
        $oxigenoActual = $this->hojaOxigenos;
        $estanciaId = $this->formularioInstancia->estancia_id;   

        $oxigenoHeredado = HojaOxigeno::whereHasMorph(
            'itemable', 
            [HojaEnfermeria::class],
            function ($query) use ($estanciaId) {
                $query->where('id', '<', $this->id)
                      ->whereHas('formularioInstancia', function ($q) use ($estanciaId) {
                          $q->where('estancia_id', $estanciaId);
                      });
            }
        )
        ->where(function($query) {
            $query->whereNull('hora_fin')
                  ->orWhere('hora_fin', '>=', $this->created_at);
        })
        ->get();

        $resultado = $oxigenoActual->merge($oxigenoHeredado);
        return $resultado->loadMissing(['userInicio', 'userFin']);
    }

    public function solicitudPatologia(): MorphMany
    {
        return $this->morphMany(SolicitudPatologia::class,'itemable');
    }
}
