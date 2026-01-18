<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $habitacion_id
 * @property string $horario_inicio
 * @property string $horario_fin
 * @property string $precio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Habitacion $habitacion
 * @property-read \App\Models\ReservacionHorario|null $reservacionHorario
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereHabitacionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereHorarioFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereHorarioInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HabitacionPrecio whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HabitacionPrecio extends Model
{
    protected $table = 'habitacion_precios';

    protected $fillable = [
        'habitacion_id',
        'horario_inicio',
        'horario_fin',
        'precio',
    ];

    public function habitacion():BelongsTo
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function reservacionHorario(): HasOne
    {
        return $this->hasOne(ReservacionHorario::class);
    }
}
