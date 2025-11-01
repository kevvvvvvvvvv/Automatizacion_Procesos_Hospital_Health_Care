<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HojaSondaCateter extends Model
{
    protected $table = 'hoja_sonda_cateters';

    protected $fillable = [
        'id',
        'tipo_dispositivo',
        'calibre',
        'fecha_instalacion',
        'fecha_caducidad',
        'user_id',
        'observaciones',
        'estancia_id',
    ];

    public function estancia():BelongsTo
    {
        return $this->belongsTo(Estancia::class,'estancia_id','id');
    }

    public function user():BelongsTo
    {
        return $this->belongs(User::class,'user_id','id');
    }

}
