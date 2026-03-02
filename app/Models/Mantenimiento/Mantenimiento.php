<?php

namespace App\Models\Mantenimiento;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Habitacion\Habitacion;
use App\Models\User;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento';

    protected $fillable = [
        'tipo_servicio',
        'comentarios',
        'resultado_aceptado',
        'observaciones',
        'duracion_espera',
        'duracion_actividad',
        'habitacion_id',
        'user_solicita_id',
        'user_ejecuta_id',
        'fecha_solicita', 
        'fecha_arregla'  
    ];

    protected $casts = [
        'fecha_solicita' => 'datetime',
        'fecha_arregla' => 'datetime',
        'resultado_aceptado' => 'boolean',
    ];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'user_solicita_id');
    }

    public function ejecutor()
    {
        return $this->belongsTo(User::class, 'user_ejecuta_id');
    }
}
