<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{   
    public const aumento = 0.20;
    public const precio = 0; 
    protected $table = 'reservaciones';
    protected $fillable = [
        'localizacion',
        'fecha',
        'habitacion_id',
        'user_id',
    ];
        public function horarios()
        {
            return $this->hasMany(ReservacionHorario::class);
        }

        public function habitacion()
        {
            return $this->belongsTo(Habitacion::class);
        }

}

