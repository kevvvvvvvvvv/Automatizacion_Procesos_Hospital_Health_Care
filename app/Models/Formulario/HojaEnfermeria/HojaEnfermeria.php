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

    public function solicitudPatologia(): MorphMany
    {
        return $this->morphMany(SolicitudPatologia::class,'itemable');
    }
}
