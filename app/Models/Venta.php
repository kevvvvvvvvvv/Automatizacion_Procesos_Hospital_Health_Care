<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    public const ESTADO_PENDIENTE = 'En espera de pago';
    public const ESTADO_PARCIAL = 'Pago parcial';
    public const ESTADO_PAGADO = 'Pagado';

    protected $table = "ventas";
    public $incrementing = true;
    
    protected $fillable = [
        'fecha',
        'subtotal',
        'total',
        'descuento',
        'estado',
        'total_pagado',
        'estancia_id',
        'user_id',
    ];

    protected $appends = ['saldo_pendiente', 'pagado_completo'];

    // Calcula cuánto falta por pagar
    public function getSaldoPendienteAttribute()
    {
        return max(0, $this->total - $this->total_pagado);
    }

    // Calcula si hay cambio (si pagaron de más)
    public function getCambioAttribute()
    {
        return max(0, $this->total_pagado - $this->total);
    }

    // Booleano simple para saber si ya se liquidó
    public function getPagadoCompletoAttribute()
    {
        return $this->total_pagado >= $this->total;
    }

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    } 
}
