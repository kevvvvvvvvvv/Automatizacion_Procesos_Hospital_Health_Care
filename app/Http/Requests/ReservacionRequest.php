<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ReservacionHorario;

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
            'localizacion' => ['required', 'string', 'in:plan_ayutla,acapantzingo'],
            'fecha' => ['required', 'date'],
            
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'localizacion.required' => 'Debe seleccionar una localización.',
            'localizacion.string' => 'La localización no es válida.',
            'localizacion.in' => 'La localización debe ser Plan de Ayutla o Diaz ordas.',

            'fecha.required' => 'Debe seleccionar una fecha.',
            'fecha.date' => 'La fecha no tiene un formato válido.',

            ];
    }

    /**
     * Advanced validation (cupos por horario y localización)
     */
    
}
