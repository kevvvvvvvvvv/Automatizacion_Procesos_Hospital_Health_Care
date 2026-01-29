<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaFrontalRequest extends FormRequest
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
            'notas' => [
                'nullable',
                'string',
                'max:1000' 
            ],
            'medico_id' => [
                'required',
                'integer',
                'exists:users,id' 
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'medico_id.required' => 'Es obligatorio seleccionar un médico.',
            'medico_id.integer'  => 'El identificador del médico debe ser un número entero.',
            'medico_id.exists'   => 'El médico seleccionado no se encuentra en nuestros registros.',

            'notas.string' => 'El formato de las notas es inválido (debe ser texto).',
            'notas.max'    => 'Las notas no pueden exceder los :max caracteres.',
        ];
    }


}
