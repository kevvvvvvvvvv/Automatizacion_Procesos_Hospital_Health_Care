<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HabitacionRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //  
            'identificador' => ['required', 'String'],
            'tipo' => ['required', 'string'],
            'piso' => ['required', 'string'],
        ];
    }
    public function messages(): array{
        return[
            'identificador.required' => 'Es obligatorio el identificador de la habitación',
            'identificador.string' => 'El campo es un texto',
            
            'tipo.required' => 'Es obligatorio el campo',
            'tipo.string' => 'Debes seleccionar un tipo',

            'piso.required' => 'Es obligatorio el campo',
            'piso.string' => 'Debe ser texto el piso',
        ];
    }
}
