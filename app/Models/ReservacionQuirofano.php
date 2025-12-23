<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservacionQuirofano extends Model
{
    protected $fillable = [
        'habitacion_id',
        'user_id',
        'estancia_id',
        'paciente',         // Agregado: para guardar el nombre manual o de estancia
        'tratante',         // Agregado: médico tratante
        'procedimiento',
        'tiempo_estimado',
        'medico_operacion', // Cirujano
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
        'horarios' => 'array', // Crucial para manejar el JSON de la base de datos
        'fecha' => 'date',
    ];

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // En App\Models\Estancia.php

public function paciente()
{
    // Asegúrate de que la llave foránea sea correcta (ej. paciente_id)
    return $this->belongsTo(Paciente::class, 'paciente_id');
}

    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(Habitacion::class);
    }
}