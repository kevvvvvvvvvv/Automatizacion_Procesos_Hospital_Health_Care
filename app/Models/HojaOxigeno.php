<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaOxigeno extends Model
{
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'hora_inicio',
        'hora_fin',
        'litros_minuto',
    ];

    public $timestamps = false;

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class, 'id','id');
    }
}
