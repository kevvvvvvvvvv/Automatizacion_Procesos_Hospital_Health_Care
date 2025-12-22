<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionHorario extends Model
{
    protected $fillable = [
        'reservacion_id',
        'habitacion_id',
        'fecha_hora',
    ];

    /* =========================
       Relaciones
    ========================= */
    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class);
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
}
