<?php

namespace App\Http\Requests\Encuestas;

use Illuminate\Foundation\Http\FormRequest;

class EncuestaSatisfaccionRequest extends FormRequest
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
            'atencion_recpcion' => ['required','integer','between:min,max'],
            'trato_personal_enfermeria',
            'limpieza_comodidad_habitacion',
            'calidad_comida',
            'tiempo_atencion',
            'informacion_tratamiento',
            'atencion_nutricional',
            'comentarios',
        ];
    }
}
