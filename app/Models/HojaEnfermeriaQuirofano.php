<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HojaEnfermeriaQuirofano extends Model
{
    
    public $incrementing = false;
    protected $fillable = [
        'id',
        'hora_inicio_cirugia',
        'hora_inicio_anestesia',
        'hora_inicio_paciente',
        'hora_fin_cirugia',
        'hora_fin_anestesia',
        'hora_fin_paciente'
    ];

    public function formularioInstancia(): BelongsTo
    {
        return $this->belongsTo(FormularioInstancia::class, 'id', 'id');
    }

    public function hojaInsumosBasicos(): HasMany
    {
        return $this->hasMany(HojaInsumosBasicos::class);
    }

}
