<?php

// app/Http/Requests/ReservacionRequest.php

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
        // Asegúrate de que solo los usuarios autenticados puedan realizar esta solicitud.
        // O si quieres permitir a todos, cámbialo a true.
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Define las opciones de localización que tienes en tu frontend.
        $localizacionesPermitidas = ['plan_ayutla', 'acapantzingo'];

        return [
            'localizacion' => [
                'required', 
                'string', 
                // Asegura que la localización sea una de las permitidas
                Rule::in($localizacionesPermitidas)
            ],
            'fecha' => [
                'required', 
                'date',
                'after_or_equal:today' // Asegura que no se reserve en el pasado
            ],
            'horarios' => [
                'required', 
                'array', 
                'min:1' // El array debe tener al menos un elemento
            ],
            // Regla para cada elemento del array de horarios
            'horarios.*' => [
                'required', 
                'date_format:Y-m-d H:i', // Valida el formato que estás enviando (Ej: 2025-12-15 08:00)
            ],
        ];
    }
    
    
    // Agregamos el método messages() a continuación
    // ...
}
