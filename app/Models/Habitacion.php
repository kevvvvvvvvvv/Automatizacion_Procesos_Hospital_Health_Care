<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habitacion extends Model
{
    protected $table = 'habitaciones';
    public $incrementing = true;
    
    protected $fillable = [
        'identificador',
        'tipo',
        'ubicacion',
        'estado',
        'piso',
    ];

    public $timestamps = false;

    public function estancias():HasOne
    {
        return $this->hasOne(Estancia::class, 'habitacion_id');
    }

    public function estanciaActiva()
    {
        return $this->hasOne(Estancia::class)
                    ->where('tipo_estancia', 'Hospitalizacion') 
                    ->whereNull('fecha_egreso');              
    }

    public function habitacionPrecios(): HasMany 
    {
        return $this->hasMany(HabitacionPrecio::class);
    }


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
