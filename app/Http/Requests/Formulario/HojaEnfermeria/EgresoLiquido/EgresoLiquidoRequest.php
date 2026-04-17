<?php

namespace App\Http\Requests\Formulario\HojaEnfermeria\EgresoLiquido;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EgresoLiquidoRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'liquidable_id' => 'required',
            'liquidable_type' => 'required',
            'tipo' => 'required',
            'cantidad' => 'required|integer',
            'descripcion' => 'nullable|string',
        ];
    }

    public function attributes()
    {
        return [
            'tipo' => 'tipo',
            'cantidad' => 'cantidad',
            'descripcion' => 'descripción',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'integer' => 'El campo :attribute debe ser un número.'
        ];
    }
}
