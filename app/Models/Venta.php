<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $fecha
 * @property string $subtotal
 * @property string $total
 * @property string|null $descuento
 * @property string $estado
 * @property string $total_pagado
 * @property int|null $estancia_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DetalleVenta> $detalles
 * @property-read int|null $detalles_count
 * @property-read \App\Models\Estancia|null $estancia
 * @property-read mixed $cambio
 * @property-read mixed $pagado_completo
 * @property-read mixed $saldo_pendiente
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereDescuento($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereEstanciaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereTotalPagado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Venta whereUserId($value)
 * @mixin \Eloquent
 */
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
