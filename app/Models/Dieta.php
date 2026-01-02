<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dieta extends Model
{
    
    protected $fillable = [
        'categoria_dieta_id',
        'alimento',
        'costo'
    ];


    public function categoriaDieta(): BelongsTo
    {
        return $this->belongsTo(CategoriaDieta::class);
    }

    public function detallesVenta()
    {
        return $this->morphMany(DetalleVenta::class,'itemable');
    }
}
