<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValoracionDolor extends Model
{
    protected $fillable = [
        'escala_eva',
        'ubicacion_dolor',

        'hoja_escala_valoracion_id'
    ];

    public function hojaEscalaValoracion(): BelongsTo
    {
        return $this->belongsTo(HojaEscalaValoracion::class);
    }
}
