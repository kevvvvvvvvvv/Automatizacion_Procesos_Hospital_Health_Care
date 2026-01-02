<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionQuirofano extends Model
{
    // Esto permite que el método fill($data) funcione
    protected $fillable = [
        'paciente',
        'paciente_id',
        'estancia_id',
        'procedimiento',
        'tratante',
        'tiempo_estimado',
        'medico_operacion',
        'fecha',
        'horarios',
        'localizacion',
        'habitacion_id',
        'user_id',
        'comentarios',
        'instrumentista',
        'anestesiologo',
        'insumos_medicamentos',
        'esterilizar_detalle',
        'rayosx_detalle',
        'patologico_detalle',
        'laparoscopia_detalle'
    ];

    // No olvides los casts para los horarios
    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date'
    ];

    // Relaciones
    public function user() { return $this->belongsTo(User::class); }
    public function habitacion() { return $this->belongsTo(Habitacion::class); }
}   