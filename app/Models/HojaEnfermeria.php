<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
}
