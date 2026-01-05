<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaSondaCateteresRequest extends FormRequest
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
            'producto_servicio_id' => 'required | numeric',
            'fecha_instalacion' => 'nullable | date',
            'fecha_caducidad' => 'nullable | date',
            'observaciones' => 'nullable | string'
        ];
    }

    public function messages()
    {
        return [
            'producto_servicio_id.required' => 'Debes seleccionar un producto o servicio.',
            'producto_servicio_id.numeric'  => 'El identificador del producto no es válido.',
            'fecha_instalacion.date'        => 'La fecha de instalación debe ser una fecha válida.',
            'fecha_caducidad.date'          => 'La fecha de caducidad debe ser una fecha válida.',
            'observaciones.string'          => 'Las observaciones deben ser texto.',
        ];
    }
}
