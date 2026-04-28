<?php

namespace App\Models\Caja;

use App\Models\User;
use App\Models\Venta\MetodoPago;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $sesion_caja_id
 * @property string|null $nombre_paciente nombre del paciente de manera temporal
 * @property string $tipo Indica si el dinero entró o salió de la caja física (ingreso o egreso)
 * @property numeric $monto Cantidad de dinero del movimiento
 * @property string|null $area A que área hace referencia el concepto a colocar
 * @property string $concepto Motivo (ej. Pago de garrafones, retiro de exceso de efectivo)
 * @property string|null $descripcion La descripcion con informacion general de los ingresos y egresos
 * @property int|null $factura
 * @property string|null $comprobante Ruta al archivo o foto del ticket de respaldo
 * @property int $user_id
 * @property int|null $metodo_pago_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read MetodoPago|null $metodoPago
 * @property-read \App\Models\Caja\SesionCaja $sesionCaja
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereComprobante($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereConcepto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereFactura($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereMetodoPagoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereNombrePaciente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereSesionCajaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereTipo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MovimientoCaja whereUserId($value)
 * @mixin \Eloquent
 */
class MovimientoCaja extends Model
{
    protected $fillable = [
        'id',
        'sesion_caja_id',
        'user_id',
        'tipo',
        'monto',
        'area',
        'concepto',
        'comprobante',
        'descripcion',

        'factura',

        'nombre_paciente',
        'metodo_pago_id',
    ];

    public function sesionCaja(): BelongsTo
    {
        return $this->belongsTo(SesionCaja::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }
}
