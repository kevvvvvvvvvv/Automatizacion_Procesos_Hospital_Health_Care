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
        'estancia_id',
        'user_id',
    ];

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
