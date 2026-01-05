<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaSondaCateter extends Model
{
    protected $table = 'hoja_sonda_cateters';

    protected $fillable = [
        'id',

        'producto_servicio_id',

        'fecha_instalacion',
        'fecha_caducidad',
        'user_id',
        'observaciones',
        'hoja_enfermeria_id',
    ];

    public function hojaEnfermeria(): BelongsTo
    {
        return $this->belongsTo(HojaEnfermeria::class);
    }

    public function user():BelongsTo
    {
        return $this->belongs(User::class,'user_id','id');
    }

    public function productoServicio(): BelongsTo
    {
        return $this->belongsTo(ProductoServicio::class);
    }

}
