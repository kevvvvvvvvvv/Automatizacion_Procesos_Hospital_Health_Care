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
        'estado',
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

    public function soliciudesDieta(): HasMany
    {
        return $this->hasMany(SolicitudDieta::class);
    }

}
