<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HabitacionPrecio extends Model
{
    protected $table = 'habitacion_precios';

    protected $fillable = [
        'habitacion_id',
        'horario_inicio',
        'horario_fin',
        'precio',
    ];

    public function habitacion():BelongsTo
    {
        return $this->belongsTo(Habitacion::class);
    }
}
