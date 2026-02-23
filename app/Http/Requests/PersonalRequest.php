<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonalRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Si tienes sistema de roles, aquí podrías verificar si el usuario es admin/staff
        return true; 
    }

    public function rules(): array
    {
        return [
            'trato_claro' => 'required|integer|min:1|max:5',
            'presentacion_personal' => 'required|integer|min:1|max:5',
            'tiempo_atencion' => 'required|integer|min:1|max:5',
            'informacion_tratamiento' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Personalizar los nombres de los campos para los errores.
     */
    public function attributes(): array
    {
        return [
            'trato_claro' => 'trato recibido',
            'presentacion_personal' => 'presentación del personal',
            'tiempo_atencion' => 'tiempo de atención',
            'informacion_tratamiento' => 'información sobre el tratamiento',
            'comentarios' => 'observaciones',
        ];
    }

    /**
     * Mensajes específicos (opcional, pero recomendado).
     */
    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'min' => 'La puntuación mínima para :attribute es :min.',
            'max' => 'La puntuación máxima para :attribute es :max.',
            'integer' => 'El valor de :attribute debe ser un número entero.',
        ];
    }
}