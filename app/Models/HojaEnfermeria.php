<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HojaEnfermeria extends Model
{
    public const CATALOGO_ID = 4;
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
}
