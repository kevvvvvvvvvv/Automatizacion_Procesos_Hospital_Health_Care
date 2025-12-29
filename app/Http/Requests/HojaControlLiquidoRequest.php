<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaControlLiquidoRequest extends FormRequest
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
            'uresis' => ['nullable', 'integer', 'min:0'],
            'evacuaciones' => ['nullable', 'integer', 'min:0'],
            'emesis' => ['nullable', 'integer', 'min:0'],
            'drenes' => ['nullable', 'integer', 'min:0'],

            'uresis_descripcion' => ['nullable', 'string', 'max:255'],
            'evacuaciones_descripcion' => ['nullable', 'string', 'max:255'],
            'emesis_descripcion' => ['nullable', 'string', 'max:255'],
            'drenes_descripcion' => ['nullable', 'string', 'max:255'],
            'estado_conciencia' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        return [ 
            // --- Uresis ---
            'uresis.integer' => 'La cantidad de uresis debe ser un número entero.',
            'uresis.min' => 'La cantidad de uresis no puede ser un valor negativo.',
            'uresis_descripcion.string' => 'La descripción de uresis debe ser un texto.',
            'uresis_descripcion.max' => 'La descripción de uresis no debe exceder 255 caracteres.',

            // --- Evacuaciones ---
            'evacuaciones.integer' => 'La cantidad de evacuaciones debe ser un número entero.',
            'evacuaciones.min' => 'La cantidad de evacuaciones no puede ser un valor negativo.',
            'evacuaciones_descripcion.string' => 'La descripción de evacuaciones debe ser un texto.',
            'evacuaciones_descripcion.max' => 'La descripción de evacuaciones no debe exceder 255 caracteres.',

            // --- Emesis ---
            'emesis.integer' => 'La cantidad de emesis debe ser un número entero.',
            'emesis.min' => 'La cantidad de emesis no puede ser un valor negativo.',
            'emesis_descripcion.string' => 'La descripción de emesis debe ser un texto.',
            'emesis_descripcion.max' => 'La descripción de emesis no debe exceder 255 caracteres.',

            // --- Drenes ---
            'drenes.integer' => 'La cantidad de drenes debe ser un número entero.',
            'drenes.min' => 'La cantidad de drenes no puede ser un valor negativo.',
            'drenes_descripcion.string' => 'La descripción de drenes debe ser un texto.',
            'drenes_descripcion.max' => 'La descripción de drenes no debe exceder 255 caracteres.',
        ];
    }
}
