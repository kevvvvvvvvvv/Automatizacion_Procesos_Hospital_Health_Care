<?php

namespace App\Models\Venta;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    protected $fillable = [
        'id',
        'pago_id',
        'detalle_venta_id',
        'monto_aplicado',
    ];

    public function pagos(): BelongsTo
    {
        return $this->belongsTo(Pago::class);
    }

    public function detalleVenta(): BelongsTo
    {
        return $this->detalleVenta(DetalleVenta::class);
    }   
}
