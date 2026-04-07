<?php

namespace App\Models\Caja;

use App\Models\User;
use App\Models\Venta\Pago;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
