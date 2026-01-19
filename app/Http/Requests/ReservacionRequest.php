<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'localizacion' => ['required','string',],
            'fecha' => ['required','date','after_or_equal:today'],
            'horarios' => ['required','array','min:1'],
            'horarios.*' => ['required', 'date_format:H:i:s'],
        ];
    }

    /**
     * Mensajes personalizados para el usuario.
     */
    public function messages(): array
    {
        return [
            'localizacion.required' => 'La ubicación es obligatoria.',
            'localizacion.in' => 'La ubicación seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'No puedes realizar reservaciones en fechas pasadas.',
            'horarios.required' => 'Debes seleccionar al menos un horario.',
            'horarios.array' => 'El formato de los horarios es inválido.',
            'horarios.*.date_format' => 'El formato de hora no es válido.',
        ];
    }
}