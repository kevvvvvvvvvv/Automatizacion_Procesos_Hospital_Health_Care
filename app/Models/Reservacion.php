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
        'estatus',
        'user_id',
        'stripe_payment_id'
    ];

    public function horarios()
    {
        return $this->hasMany(ReservacionHorario::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
