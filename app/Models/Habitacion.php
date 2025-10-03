<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Habitacion extends Model
{
    protected $table = 'habitaciones';
    public $incrementing = true;
    
    protected $fillable = [
        'identificar',
        'estado',
        'piso',
    ];

    public function estancias():HasOne
    {
        return $this->hasOne(Estancia::class.'habitacion_id');
    }

}
