<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionHorario extends Model
{
    protected $fillable = [
        'reservacion_id',
        'fecha_hora',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class);
    }
}
