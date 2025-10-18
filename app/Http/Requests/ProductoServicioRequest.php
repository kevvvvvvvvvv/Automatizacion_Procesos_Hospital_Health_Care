<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoServicioRequest extends FormRequest
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
            'tipo' => 'required|string',
            'subtipo' => 'required|string',
            'codigo_prestacion' => 'required|string',
            'nombre_prestacion' => 'required|string',
            'importe' => 'required|numeric',
            'cantidad' => 'nullable|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tipo.required' => 'Debe seleccionar un tipo.',
            'tipo.string' => 'El tipo seleccionado no es válido.',

            'subtipo.required' => 'Debe seleccionar un subtipo.',
            'subtipo.string' => 'El subtipo seleccionado no es válido.',

            'codigo_prestacion.required' => 'El código de la prestación es obligatorio.',
            'codigo_prestacion.string' => 'El código de la prestación debe ser texto.',

            'nombre_prestacion.required' => 'El nombre de la prestación es obligatorio.',
            'nombre_prestacion.string' => 'El nombre de la prestación debe ser texto.',

            'importe.required' => 'El importe es obligatorio.',
            'importe.numeric' => 'El importe debe ser un valor numérico.',

            'cantidad.numeric' => 'La cantidad debe ser un valor numérico.',
        ];
    }
}
