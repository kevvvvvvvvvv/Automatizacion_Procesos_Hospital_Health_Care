<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'fecha_solicita', // Sincronizado
        'fecha_arregla'   // Sincronizado
    ];

    // Esto convierte los strings de la BD a objetos de fecha automáticamente
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