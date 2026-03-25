<?php

namespace App\Http\Requests\Caja;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudTraspasoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'caja_origen_id' => 'required|exists:cajas,id', // A quién le pide
            'caja_destino_id' => 'required|exists:cajas,id', // Quién pide 
            'monto' => 'required|numeric|min:1',
            'concepto' => 'required|string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'caja_origen_id' => 'caja de origen',
            'caja_destino_id' => 'caja de destino',
            'monto' => 'monto',
            'concepto' => 'concepto',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'exists' => 'La :attribute seleccionada no existe en el sistema.',
            'numeric' => 'El :attribute debe ser un número válido.',
            'min' => 'El :attribute debe ser de al menos $:min.',
            'string' => 'El :attribute debe ser texto válido.',
            'max' => 'El :attribute no puede exceder los :max caracteres.',
        ];
    }
}
