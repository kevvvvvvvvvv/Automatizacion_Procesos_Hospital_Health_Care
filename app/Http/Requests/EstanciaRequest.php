<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstanciaRequest extends FormRequest
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
            'fecha_ingreso'           => 'required|date',
            'tipo_estancia'          => 'required|string|in:Hospitalizacion,Interconsulta',
            'tipo_ingreso'           => 'required|string|in:Ingreso,Reingreso',
            'modalidad_ingreso'      => 'required|string',
            'estancia_anterior_id' => 'nullable|required_if:tipo_ingreso,Reingreso|exists:estancias,id',
        ];
    }

    public function messages()
    {
        return [
            'fechaIngreso.required' => 'La fecha de ingreso es obligatoria.',
            'fechaIngreso.date' => 'El campo fecha de ingreso debe ser una fecha válida.',

            'tipo_estancia.required' => 'El tipo de estancia es obligatorio.',
            'tipo_estancia.in' => "El tipo de estancia seleccionado no es válido.",

            'tipo_ingreso.required' => 'El tipo de ingreso es obligatorio.',
            'tipo_ingreso.in' => "El tipo de ingreso seleccionado no es válido.",

            'num_habitacion.string' => 'El número de habitación debe ser texto.',
            'num_habitacion.max' => 'El número de habitación no debe exceder los 255 caracteres.',

            'estancia_referencia_id.required_if' => 'La estancia de referencia es obligatoria cuando el tipo de ingreso es "Reingreso".',
            'estancia_referencia_id.exists' => 'La estancia de referencia seleccionada no existe o no es válida.',
        
            'modalidad_ingreso' => 'El campo de modalidad de ingreso es obligatorio.'
        ];
    }
}
