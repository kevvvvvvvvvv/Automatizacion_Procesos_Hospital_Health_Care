<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
       public function horarios()
    {
        return $this->hasMany(ReservacionHorario::class);
    }
    public function formularioInstancia()
{
    // Ajusta esto según tu base de datos. 
    // Si 'formulario_instancia' es otra tabla que tiene el id de estancia:
    return $this->hasOne(FormularioInstancia::class, 'estancia_id');
}

public function paciente()
{
    return $this->belongsTo(Paciente::class, 'paciente_id');
}
}
