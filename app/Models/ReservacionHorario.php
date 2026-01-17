<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionHorario extends Model
{
    protected $fillable = [
        'reservacion_id',
        'habitacion_precio_id',
        'fecha_hora',
    ];


    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class);
    }

    public function habitacionPrecio(): BelongsTo
    {
        return $this->belongsTo(HabitacionPrecio::class);
    }
}
