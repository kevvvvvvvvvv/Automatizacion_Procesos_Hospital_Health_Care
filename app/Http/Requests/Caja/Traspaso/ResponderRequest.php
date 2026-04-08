<?php

namespace App\Http\Requests\Caja\Traspaso;

use Illuminate\Foundation\Http\FormRequest;

class ResponderRequest extends FormRequest
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
            'aprobar' => 'required|boolean',
            'monto_aprobado' => 'required_if:aprobar,true|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'aprobar' => 'decisión de aprobación',
            'monto_aprobado' => 'monto a aprobar',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'boolean' => 'El campo :attribute debe ser una respuesta de sí o no válida.',
            'required_if' => 'Debes ingresar un :attribute si decides autorizar la solicitud.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'min' => 'El campo :attribute no puede ser un valor negativo.',
        ];
    }
}
