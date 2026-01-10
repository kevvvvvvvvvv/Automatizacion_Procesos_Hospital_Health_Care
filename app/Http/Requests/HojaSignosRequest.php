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
            'tension_arterial_sistolica' => ['nullable', 'integer', 'min:0', 'required_with:tension_arterial_diastolica'],
            'tension_arterial_diastolica' => ['nullable', 'integer', 'min:0', 'required_with:tension_arterial_sistolica'],
            'frecuencia_cardiaca' => ['nullable', 'integer', 'min:0'],
            'frecuencia_respiratoria' => ['nullable', 'integer', 'min:0'],
            'saturacion_oxigeno' => ['nullable', 'integer', 'min:0', 'max:100'], 
            'glucemia_capilar' => ['nullable', 'integer', 'min:0'],
            'temperatura' => ['nullable', 'numeric', 'min:0'],
            'talla' => ['nullable', 'numeric', 'min:0'],
            'peso' => ['nullable', 'numeric', 'min:0'],
            'estado_conciencia' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            // --- T.A. Sistólica ---
            'tension_arterial_sistolica.integer' => 'La T.A. sistólica debe ser un número entero.',
            'tension_arterial_sistolica.min' => 'La T.A. sistólica no puede ser un valor negativo.',
            'tension_arterial_sistolica.required_with' => 'Debes ingresar ambas cifras de la tensión arterial (sistólica y diastólica).',
            'tension_arterial_diastolica.required_with' => 'Debes ingresar ambas cifras de la tensión arterial (sistólica y diastólica).',

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

            // --- Temperatura, Talla, Peso ---
            'temperatura.numeric' => 'La temperatura debe ser un valor numérico.',
            'temperatura.min' => 'La temperatura no puede ser un valor negativo.',
            
            'talla.numeric' => 'La talla debe ser un valor numérico.',
            'talla.min' => 'La talla no puede ser un valor negativo.',

            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'peso.min' => 'El peso no puede ser un valor negativo.',

            // --- Estado ---
            'estado_conciencia.string' => 'El estado de conciencia debe ser un texto.',
            'estado_conciencia.max' => 'El estado de conciencia no debe exceder 255 caracteres.',

        ];
    }
}
