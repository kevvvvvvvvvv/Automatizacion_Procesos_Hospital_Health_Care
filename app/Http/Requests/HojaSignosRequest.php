<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaSignosRequest extends FormRequest
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
            'tension_arterial_sistolica' => ['nullable', 'integer', 'min:0'],
            'tension_arterial_diastolica' => ['nullable', 'integer', 'min:0'],
            'frecuencia_cardiaca' => ['nullable', 'integer', 'min:0'],
            'frecuencia_respiratoria' => ['nullable', 'integer', 'min:0'],
            'saturacion_oxigeno' => ['nullable', 'integer', 'min:0', 'max:100'], 
            'glucemia_capilar' => ['nullable', 'integer', 'min:0'],
            'uresis' => ['nullable', 'integer', 'min:0'],
            'evacuaciones' => ['nullable', 'integer', 'min:0'],
            'emesis' => ['nullable', 'integer', 'min:0'],
            'drenes' => ['nullable', 'integer', 'min:0'],

            'temperatura' => ['nullable', 'numeric', 'min:0'],
            'talla' => ['nullable', 'numeric', 'min:0'],
            'peso' => ['nullable', 'numeric', 'min:0'],

            'uresis_descripcion' => ['nullable', 'string', 'max:255'],
            'evacuaciones_descripcion' => ['nullable', 'string', 'max:255'],
            'emesis_descripcion' => ['nullable', 'string', 'max:255'],
            'drenes_descripcion' => ['nullable', 'string', 'max:255'],
            'estado_conciencia' => ['nullable', 'string', 'max:255'],

            'escala_braden' => ['nullable', 'numeric', 'between:1,25'],
            'escala_glasgow' => ['nullable', 'numeric', 'between:0,25'],
            'escala_ramsey' => ['nullable', 'numeric', 'between:1,6'],
            'escala_eva' => ['nullable', 'numeric', 'between:0,10'],
        ];
    }

    public function messages(): array
    {
        return [
            // --- T.A. Sistólica ---
            'tension_arterial_sistolica.integer' => 'La T.A. sistólica debe ser un número entero.',
            'tension_arterial_sistolica.min' => 'La T.A. sistólica no puede ser un valor negativo.',

            // --- T.A. Diastólica ---
            'tension_arterial_diastolica.integer' => 'La T.A. diastólica debe ser un número entero.',
            'tension_arterial_diastolica.min' => 'La T.A. diastólica no puede ser un valor negativo.',

            // --- Frecuencia Cardíaca ---
            'frecuencia_cardiaca.integer' => 'La frecuencia cardíaca debe ser un número entero.',
            'frecuencia_cardiaca.min' => 'La frecuencia cardíaca no puede ser un valor negativo.',

            // --- Frecuencia Respiratoria ---
            'frecuencia_respiratoria.integer' => 'La frecuencia respiratoria debe ser un número entero.',
            'frecuencia_respiratoria.min' => 'La frecuencia respiratoria no puede ser un valor negativo.',

            // --- Saturación de Oxígeno ---
            'saturacion_oxigeno.integer' => 'La saturación de oxígeno debe ser un número entero.',
            'saturacion_oxigeno.min' => 'La saturación de oxígeno no puede ser un valor negativo.',
            'saturacion_oxigeno.max' => 'La saturación de oxígeno no puede ser mayor a 100.',

            // --- Glucemia Capilar ---
            'glucemia_capilar.integer' => 'La glucemia capilar debe ser un número entero.',
            'glucemia_capilar.min' => 'La glucemia capilar no puede ser un valor negativo.',

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

            // --- Temperatura, Talla, Peso ---
            'temperatura.numeric' => 'La temperatura debe ser un valor numérico.',
            'temperatura.min' => 'La temperatura no puede ser un valor negativo.',
            
            'talla.numeric' => 'La talla debe ser un valor numérico.',
            'talla.min' => 'La talla no puede ser un valor negativo.',

            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'peso.min' => 'El peso no puede ser un valor negativo.',

            // --- Escalas y Estado ---
            'estado_conciencia.string' => 'El estado de conciencia debe ser un texto.',
            'estado_conciencia.max' => 'El estado de conciencia no debe exceder 255 caracteres.',

            'escala_braden.between' => 'La escala Braden debe estar entre 1 y 25.',
            'escala_glasgow.between' => 'La escala Glasgow debe estar entre 0 y 15.',
            'escala_ramsey.between' => 'La escala Ramsey debe estar entre 1 y 6.',
            'escala_eva.between' => 'La escala EVA debe estar entre 0 y 10.',
        ];
    }
}
