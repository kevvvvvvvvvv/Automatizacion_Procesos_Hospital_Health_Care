<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservacionQuirofano extends Model
{
   public function rules(): array
{
    return [
        'estancia_id'          => 'nullable|exists:estancias,id',
        'paciente'             => 'nullable|string|max:255',
        'tratante'             => 'required|string|max:255',
        'procedimiento'        => 'required|string|max:500',
        'tiempo_estimado'      => 'required|string|max:100',
        'medico_operacion'     => 'required|string|max:255',
        'fecha'                => 'required|date|after_or_equal:today',
        'horarios'             => 'required|array|min:1',
        'instrumentista'       => 'nullable|string',
        'anestesiologo'        => 'nullable|string',
        'insumos_medicamentos' => 'nullable|string',
        'esterilizar_detalle'  => 'nullable|string',
        'rayosx_detalle'       => 'nullable|string',
        'patologico_detalle'   => 'nullable|string',
        'laparoscopia_detalle' => 'nullable|string', // 👈 Agrega esta línea
        'comentarios'          => 'nullable|string|max:1000',
        'localizacion'         => 'nullable|string', // 👈 Agrega esta si la vas a enviar
    ];
}

    protected $casts = [
        'horarios' => 'array',
        'fecha' => 'date:Y-m-d', // Formateado para facilitar el uso en el frontend
    ];

    // --- Relaciones ---

    public function estancia(): BelongsTo
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function habitacion(): BelongsTo
    {
        return $this->belongsTo(Habitacion::class);
    }
}