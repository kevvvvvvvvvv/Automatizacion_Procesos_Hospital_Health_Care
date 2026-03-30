<?php

namespace App\Http\Requests\Caja\Contaduria;

use Illuminate\Foundation\Http\FormRequest;

class ContaduriaRequest extends FormRequest
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
            'caja_origen_id' => 'required|exists:cajas,id', 
            'monto' => 'required|numeric|min:0.1',
            'concepto' => 'required|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'caja_origen_id' => 'caja de origen',
            'monto' => 'monto',
            'concepto' => 'concepto',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'exists' => 'La :attribute seleccionada no es válida o no existe en el sistema.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'min' => 'El campo :attribute debe ser de al menos $:min.',
            'string' => 'El campo :attribute debe contener un texto válido.',
            'max' => 'El campo :attribute no puede exceder los :max caracteres.',
        ];
    }
}
