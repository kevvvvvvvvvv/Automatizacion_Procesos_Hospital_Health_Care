<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistroPagoVentaRequest extends FormRequest
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
            'total_pagado' => 'required|numeric|min:0.01',
            'requiere_factura' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'total_pagado.required' => 'El pago a registrar es obligatorio',
            'total_pagado.number'   => 'El pago debe ser un número',
            'requiere_factura.required' => 'Debe seleccionar una opción de facturación',
        ];
    }
}
