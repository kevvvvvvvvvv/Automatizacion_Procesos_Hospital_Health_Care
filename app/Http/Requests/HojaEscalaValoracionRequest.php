<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaEscalaValoracionRequest extends FormRequest
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
            'escala_braden' => ['nullable', 'numeric', 'between:1,25'],
            'escala_glasgow' => ['nullable', 'numeric', 'between:3,15'],
            'escala_ramsey' => ['nullable', 'numeric', 'between:1,6'],
            'valoracion_dolor' =>['nullable','array'],
            'valoracion_dolor.*.escala_eva' => ['required','between:0,10'],
            'valoracion_dolor.*.ubicacion_dolor' => ['required', 'string']
        ];
    }

    public function messages()
    {
        return [
            'escala_braden.between' => 'La escala Braden debe estar entre 1 y 25.',
            'escala_glasgow.between' => 'La escala Glasgow debe estar entre 0 y 15.',
            'escala_ramsey.between' => 'La escala Ramsey debe estar entre 1 y 6.',
            'escala_eva.between' => 'La escala EVA debe estar entre 0 y 10.',
            'valoracion_dolor.*.escala_eva.between' => 'La escala EVA debe estar entre 0 y 10 en todos los registros.',
            'valoracion_dolor.*.escala_eva.required' => 'El valor de EVA es obligatorio.',
            'valoracion_dolor.*.ubicacion_dolor.required' => 'La ubicación es obligatoria',
        ];
    }
}
