<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HojaEscalaValoracion extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'fecha_hora_registro',
        'escala_braden',
        'escala_glasgow',
        'escala_ramsey',
    ];

    public function hojaEnfermeria():BelongsTo
    {   
        return $this->belongsTo(HojaEnfermeria::class,'hoja_enfermeria_id','id');
    }


    public function valoracionDolor(): HasMany
    {
        return $this->hasMany(ValoracionDolor::class);
    }

    
}
