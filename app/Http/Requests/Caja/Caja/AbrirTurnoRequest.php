<?php

namespace App\Http\Requests\Caja\Caja;

use Illuminate\Foundation\Http\FormRequest;

class AbrirTurnoRequest extends FormRequest
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
            'caja_id' => 'required|exists:cajas,id',
            'monto_inicial' => 'required|numeric|min:0',
        ];
    }

    public function attributes()
    {
        return [
            'caja_id' => 'La caja',
            'monto_inicial' => 'El monto inicial',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'exists' => 'La :attribute seleccionada no existe en el sistema.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'min' => 'El campo :attribute no puede ser menor a :min.', 
        ];
    }

}
