<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaInsumosBasicos extends Model
{
    protected $fillable = [
        'id',
        'producto_servicio_id',
        'hoja_enfermeria_quirofano_id',
        'cantidad',
    ];

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }

    public function hojaEnfermeriaQuirofano(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeriaQuirofano::class);
    }

    
}
