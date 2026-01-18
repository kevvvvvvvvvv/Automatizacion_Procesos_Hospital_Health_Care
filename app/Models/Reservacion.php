<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $localizacion
 * @property string $fecha
 * @property int $horas
 * @property string|null $pago
 * @property string $estatus
 * @property int $user_id
 * @property string|null $stripe_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReservacionHorario> $horarios
 * @property-read int|null $horarios_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereHoras($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereLocalizacion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion wherePago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereStripePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereUserId($value)
 * @mixin \Eloquent
 */
class Reservacion extends Model
{
     protected $table = 'reservaciones';
    protected $fillable = [
        'localizacion',
        'fecha',
        'horas',
        'estatus',
        'user_id',
        'pago_total',
        'stripe_payment_id'
    ];

    public function horarios()
    {
        return $this->hasMany(ReservacionHorario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
