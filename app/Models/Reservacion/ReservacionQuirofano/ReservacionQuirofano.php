<?php

namespace App\Models\Reservacion\ReservacionQuirofano;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;
use App\Models\Habitacion\Habitacion;

class ReservacionQuirofano extends Model
{
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

    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date'
    ];


    public function user(): BelongsTo 
    { 
        return $this->belongsTo(User::class); 
    }

    public function habitacion() 
    { 
        return $this->belongsTo(Habitacion::class); 
    }
}
