<?php

namespace App\Models\Reservacion\ReservacionConsultorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Habitacion\HabitacionPrecio;

class ReservacionHorario extends Model
{
    protected $fillable = [
        'reservacion_id',
        'habitacion_precio_id',
        'fecha',
    ];


    public function reservacion(): BelongsTo
    {
        return $this->belongsTo(Reservacion::class);
    }

    public function habitacionPrecio(): BelongsTo
    {
        return $this->belongsTo(HabitacionPrecio::class);
    }
}
