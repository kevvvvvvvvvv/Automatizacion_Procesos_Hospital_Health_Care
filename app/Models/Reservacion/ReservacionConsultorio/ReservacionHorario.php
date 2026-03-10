<?php

namespace App\Models\Reservacion\ReservacionConsultorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Habitacion\HabitacionPrecio;

/**
 * @property int $id
 * @property int $reservacion_id
 * @property int $habitacion_precio_id
 * @property string $fecha
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read HabitacionPrecio $habitacionPrecio
 * @property-read \App\Models\Reservacion\ReservacionConsultorio\Reservacion $reservacion
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReservacionHorario whereHabitacionPrecioId($value)
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
