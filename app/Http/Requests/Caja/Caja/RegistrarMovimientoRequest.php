<?php

namespace App\Http\Requests\Caja\Caja;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\TipoMovimientoCaja;
use Illuminate\Validation\Rules\Enum;

class RegistrarMovimientoRequest extends FormRequest
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
            'tipo' => ['required', new Enum(TipoMovimientoCaja::class)],
            'monto' => 'required|numeric|min:0.01',
            'concepto' => 'required|string|max:255',
            'metodo_pago_id' => 'required|exists:metodo_pagos,id',
            'area' => 'required|string',
            'origen' => 'required|string',
            'descripcion' => 'string|nullable',
            'factura' => 'nullable|boolean',
            'nombre_paciente' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'tipo' => 'tipo de movimiento',
            'monto' => 'monto del movimiento',
            'concepto' => 'concepto',
            'metodo_pago_id' => 'método de pago',
            'area' => 'área',
            'origen' => 'dinero de origin',
            'descripcion' => 'descripción',
            'nombre_paciente'=> 'nombre del paciente',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'enum' => 'El :attribute seleccionado no es válido.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'min' => 'El campo :attribute debe ser de al menos $:min.',
            'string' => 'El campo :attribute debe ser texto válido.',
            'max' => 'El campo :attribute no puede tener más de :max caracteres.',
            'exists' => 'El campo :attribute debe existir en los métodos de pago disponibles',
        ];
    }
}
