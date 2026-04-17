<?php

namespace App\Models\Formulario\HojaEnfermeriaQuirofano;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Isquemia extends Model
{
    protected $fillable = [
        'id',
        'isquemiable_type',
        'isquemiable_id',
        'sitio_anatomico',
        'hora_inicio',
        'hora_termino',
        'observaciones',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:Y-m-d\TH:i:sP',
        'hora_termino' => 'datetime:Y-m-d\TH:i:sP',
    ];

    public function isquemiable(): MorphTo
    {
        return $this->morphTo();
    }
}
