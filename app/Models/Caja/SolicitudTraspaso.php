<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class SolicitudTraspaso extends Model
{
    protected $fillable = [
        'caja_origen_id',
        'caja_destino_id',
        'monto_solicitado',
        'monto_aprobado',
        'estado',
        'concepto',
        'user_solicita_id',
        'user_aprueba_id',
    ];

    protected $casts = [
        'monto_solicitado' => 'decimal:2',
        'monto_aprobado' => 'decimal:2',
    ];

    public function cajaOrigen(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_origen_id');
    }

    public function cajaDestino(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_destino_id');
    }

    // El empleado que pidió el dinero
    public function usuarioSolicita(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_solicita_id');
    }

    // El contador/jefe que autorizó o rechazó el movimiento
    public function usuarioAprueba(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_aprueba_id');
    }
}
