<?php

namespace App\Models\Caja;

use App\Models\User;
use App\Models\Venta\Pago;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property int $caja_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $fecha_apertura Fecha y hora exacta en la que el cajero abrió el turno
 * @property \Illuminate\Support\Carbon|null $fecha_cierre Fecha y hora del corte de caja
 * @property numeric $monto_inicial Fondo de caja (dinero base para dar cambio al iniciar)
 * @property string $estado Estado operativo de la sesión
 * @property numeric $total_ingresos_efectivo Suma de ventas y otros ingresos en efectivo
 * @property numeric $total_egresos_efectivo Suma de retiros y pagos en efectivo
 * @property numeric $total_otros_metodos Suma de pagos con tarjeta, transferencia, etc.
 * @property numeric|null $monto_declarado Dinero físico total contado por el cajero al hacer el corte
 * @property numeric|null $sobrante_faltante Diferencia matemática: Declarado - (Inicial + Ingresos - Egresos)
 * @property numeric|null $monto_enviado_contaduria El monto que se retira de caja para enviar a contaduria.
 * @property int $auditada
 * @property numeric $monto_ajuste
 * @property string|null $observacion_auditoria
 * @property int|null $auditor_id
 * @property string|null $fecha_auditoria
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $auditor
 * @property-read \App\Models\Caja\Caja $caja
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caja\DesgloseEfectivo> $desglosesEfectivo
 * @property-read int|null $desgloses_efectivo_count
 * @property-read mixed $monto_esperado
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Caja\MovimientoCaja> $movimientos
 * @property-read int|null $movimientos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Pago> $pagos
 * @property-read int|null $pagos_count
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereAuditada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereAuditorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereCajaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereFechaApertura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereFechaAuditoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereFechaCierre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereMontoAjuste($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereMontoDeclarado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereMontoEnviadoContaduria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereMontoInicial($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereObservacionAuditoria($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereSobranteFaltante($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereTotalEgresosEfectivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereTotalIngresosEfectivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereTotalOtrosMetodos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SesionCaja whereUserId($value)
 * @mixin \Eloquent
 */
class SesionCaja extends Model
{
    protected $fillable = [
        'id',
        'caja_id',
        'user_id',

        'fecha_apertura',
        'fecha_cierre',

        'monto_inicial',
        'estado',

        'total_ingresos_efectivo',
        'total_egresos_efectivo',
        'total_otros_metodos',

        'monto_declarado',
        'sobrante_faltante',
        'monto_enviado_contaduria',

        'auditada',
        'monto_ajuste',
        'observacion_auditoria',
        'auditor_id',
        'fecha_auditoria',
    ];

    protected $casts = [
        'fecha_apertura' => 'datetime', 
        'fecha_cierre' => 'datetime', 
        'monto_inicial' => 'decimal:2',
    ];

    protected $appends = [
        'monto_esperado',
    ];

    /**
     * Calcula cuánto efectivo DEBE haber en la caja en este momento exacto.
     */
    protected function montoEsperado(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->monto_inicial + $this->total_ingresos_efectivo - $this->total_egresos_efectivo,
        );
    }
    
    public function auditor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'auditor_id');
    }

    public function caja(): BelongsTo
    {
        return $this->belongsTo(Caja::class, 'caja_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function desglosesEfectivo(): HasMany
    {
        return $this->hasMany(DesgloseEfectivo::class);
    }
}
