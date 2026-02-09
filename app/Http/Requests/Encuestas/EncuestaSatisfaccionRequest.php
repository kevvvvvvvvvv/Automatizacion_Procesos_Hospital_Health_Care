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

    
    public function rules(): array
    {
        return [
            'atencion_recpcion' => ['required','integer'],
            'trato_personal_enfermeria' => ['required','integer'],
            'limpieza_comodidad_habitacion' => ['required','integer'],
            'calidad_comida' => ['required','integer'],
            'tiempo_atencion' => ['required','integer'],
            'informacion_tratamiento' => ['required','integer'],
            'atencion_nutricional' => ['required'],
            'comentarios' => ['nullable','string'],
        ];
    }
     public function messages(): array
    {
        return [
            'atencion_recpcion.required' => 'Es obligatorio selecionar una opción',

            'trato_personal_enfermeria.required' => 'El obligatorio selecionar una opción',
            'limpieza_comodidad_habitacion.required' => 'Es obligatorio selecionar una opción',
            'calidad_comida.required' => "Debe seleccionar una opción",
            'tiempo_atencion.required' => "Debe selecionar una opción",
            'informacion_tratamiento.required' => "Debe selecionar una opción",
            'atencion_nutricional' => 'Debe seleccionar una opción',
            'comentarios.string' => 'Debe ser un texto',
        ];
    }
}
