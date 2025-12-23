<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservacionQuirofanoRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cambiar a true para permitir que los usuarios autenticados reserven
        return auth()->check(); 
    }

    public function rules(): array
    {
        return [
            'paciente'         => 'required|string|max:255',
            'procedimiento'    => 'required|string|max:500',
            'tratante'         => 'required|string',
            'medico_operacion' => 'required|string',
            'tiempo_estimado'  => 'required|string',
            'localizacion'     => 'required|string',
            'fecha'            => 'required|date|after_or_equal:today',
            'horarios'         => 'required|array|min:1',
            
            // Validación para los campos condicionales (objetos de React)
            'instrumentista'   => 'required|array',
            'anestesiologo'    => 'required|array',
            'insumos_med'      => 'nullable|array',
            'esterilizar'      => 'nullable|array',
            'rayosx'           => 'nullable|array',
            'patologico'       => 'nullable|array',
            'comentarios'      => 'nullable|string',
        ];
    }

    /**
     * Mensajes personalizados (Opcional)
     */
    public function messages(): array
    {
        return [
            'horarios.required' => 'Debe seleccionar al menos un bloque de horario.',
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
        ];
    }
}