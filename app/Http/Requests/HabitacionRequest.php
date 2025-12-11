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
            'indentificador' => ['required', 'string'],
            'tipo' => ['required', 'string'],
            'piso' => ['required', 'string,']
        ];
    }
    public function messages(): array{
        return[
            'indentificador.required' => 'Es obligatorio el indentificador de la habitación',
            'indentificador.string' => 'El campo es un texto',
            
            'tipo.required',
            '',
        ];
    }
}
