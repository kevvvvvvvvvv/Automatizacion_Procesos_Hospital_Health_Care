<?php

namespace App\Models\Reservacion\ReservacionConsultorio;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\User;

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
