<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DesgloseEfectivo extends Model
{
    protected $fillable = [
        'id',
        'sesion_caja_id',
        'denominacion',
        'cantidad',
        'total'
    ];

    public function sesionCaja(): BelongsTo
    {
        return $this->belongsTo(SesionCaja::class);
    }
}
