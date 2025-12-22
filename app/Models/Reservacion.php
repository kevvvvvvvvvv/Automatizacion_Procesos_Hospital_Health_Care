<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservacion extends Model
{
     protected $table = 'reservaciones';
    protected $fillable = [
        'localizacion',
        'fecha',
        'horas',
        'user_id',
    ];

    /* =========================
       Relaciones
    ========================= */
    public function horarios()
    {
        return $this->hasMany(ReservacionHorario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
