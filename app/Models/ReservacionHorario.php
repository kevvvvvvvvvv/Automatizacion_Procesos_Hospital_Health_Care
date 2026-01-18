<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $reservacion_id
 * @property int $habitacion_id
 * @property string $fecha_hora
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Reservacion $reservacion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereFechaHora($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereHabitacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereReservacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
