<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HonorarioRequest extends FormRequest
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
            'interconsulta_id' => ['required', 'exists:interconsultas,id'],
            'monto' => ['required', 'numeric', 'min:0'],
            'descripcion' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'interconsulta_id.required' => 'La interconsulta es obligatoria.',
            'interconsulta_id.exists' => 'La interconsulta seleccionada no existe.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'monto.min' => 'El monto no puede ser negativo.',
            'descripcion.string' => 'La descripción debe ser un texto.',
            'descripcion.max' => 'La descripción no debe exceder 255 caracteres.',
        ];
    }
}