<?php

namespace App\Models\Caja;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

/**
 * @property int $id
 * @property int $caja_origen_id
 * @property int $caja_destino_id
 * @property numeric $monto_solicitado Lo que el sistema o el usuario pide originalmente
 * @property numeric|null $monto_aprobado Lo que Contaduría decide enviar realmente (puede ser diferente al solicitado)
 * @property string $estado Estado actual de la solicitud de traspaso
 * @property string $concepto El concepto para el historial (ej. Reposición automática por retiro de Urgencias)
 * @property int $user_solicita_id
 * @property int|null $user_aprueba_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Caja\Caja $cajaDestino
 * @property-read \App\Models\Caja\Caja $cajaOrigen
 * @property-read User|null $usuarioAprueba
 * @property-read User $usuarioSolicita
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereCajaDestinoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereCajaOrigenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereMontoAprobado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereMontoSolicitado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereUserApruebaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SolicitudTraspaso whereUserSolicitaId($value)
 * @mixin \Eloquent
 */
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
