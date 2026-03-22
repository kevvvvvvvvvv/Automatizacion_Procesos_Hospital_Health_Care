<?php

namespace App\Models\Caja;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoCaja extends Model
{
    protected $fillable = [
        'id',
        'sesion_caja_id',
        'user_id',
        'tipo',
        'monto',
        'concepto',
        'comprobante',
    ];

    public function sesionCaja(): BelongsTo
    {
        return $this->belongsTo(SesionCaja::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
