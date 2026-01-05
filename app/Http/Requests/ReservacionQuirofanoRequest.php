<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservacionQuirofanoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
public function rules(): array
{
   return [
        'fecha' => ['required'],
        'horarios' => ['required', 'array'],
    ];
}

    public function messages(): array
    {
        return [
            'paciente.required' => 'El nombre del paciente es obligatorio.',
            'tratante.required' => 'El médico tratante es obligatorio.',
            'procedimiento.required' => 'Debe especificar el procedimiento.',
            'tiempo_estimado.required' => 'El tiempo estimado es obligatorio.',
            'medico_operacion.required' => 'Debe seleccionar al médico de operación.',
            'horarios.required' => 'Debe seleccionar al menos un bloque de horario.',
            'horarios.min' => 'Seleccione al menos un horario.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'Formato de fecha no válido.',
        ];
    }
}