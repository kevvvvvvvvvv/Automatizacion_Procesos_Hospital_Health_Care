<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
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

    public $timestamps = false;

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class);
    } 
}
