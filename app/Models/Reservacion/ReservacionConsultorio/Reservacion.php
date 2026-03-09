<?php

namespace App\Models\Reservacion\ReservacionConsultorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;

/**
 * @property int $id
 * @property string $fecha
 * @property string|null $pago_total
 * @property string $estatus
 * @property int $user_id
 * @property string|null $stripe_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservacion\ReservacionConsultorio\ReservacionHorario> $horarios
 * @property-read int|null $horarios_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereEstatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion wherePagoTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereStripePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservacion whereUserId($value)
 * @mixin \Eloquent
 */
class Reservacion extends Model
{
    protected $table = 'reservaciones';
    protected $fillable = [
        'fecha',
        'estatus',
        'user_id',
        'pago_total',
        'stripe_payment_id'
    ];

    public function horarios(): HasMany
    {
        return $this->hasMany(ReservacionHorario::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
