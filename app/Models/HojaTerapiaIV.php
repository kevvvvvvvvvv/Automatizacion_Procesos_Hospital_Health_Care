<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HojaTerapiaIV extends Model
{
    protected $table = 'hoja_terapias';
    
    protected $fillable = [
        'id',
        'hoja_enfermeria_id',
        'solucion',
        'flujo_ml_hora',
        'fecha_hora_inicio',
    ];

    public function solucion():BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class, 'solucion','id');
    }

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

}
