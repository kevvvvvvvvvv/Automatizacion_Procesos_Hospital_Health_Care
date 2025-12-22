<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservacionQuirofano extends Model
{
    protected $fillable = [
        'habitacion_id',
        'user_id',
        'estancia_id',
        'procedimiento',
        'tiempo_estimado',
        'medico_operacion',
        'instrumentista',
        'anestesiologo',
        'insumos_medicamentos',
        'esterilizar_detalle',
        'rayosx_detalle',
        'patologico_detalle',
        'comentarios',
        'horarios',
        'fecha',
        'localizacion'
    ];

    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date',
    ];

    public function estancia() {
        return $this->belongsTo(Estancia::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function habitacion() {
        return $this->belongsTo(Habitacion::class);
    }
}