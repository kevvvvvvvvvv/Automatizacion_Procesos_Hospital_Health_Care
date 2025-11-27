<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaEvolucionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambié a true; ajusta si necesitas verificar permisos (ej. auth()->user()->can('create', NotaEvolucion::class))
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Evolución y actualización
            'evolucion_actualizacion' => 'required|string|max:1000',

            // Signos vitales
            'ta' => 'required|string|max:20', // Ej: "120/80"
            'fc' => 'required|numeric|min:0|max:300', // Frecuencia cardíaca
            'fr' => 'required|numeric|min:0|max:100', // Frecuencia respiratoria
            'temp' => 'required|numeric|min:30|max:45', // Temperatura en °C
            'peso' => 'required|numeric|min:0|max:500', // Peso en kg
            'talla' => 'required|numeric|min:0|max:3', // Talla en m

            // Otros campos
            'resultados_relevantes' => 'nullable|string|max:1000',
            'diagnostico_problema_clinico' => 'required|string|max:1000',
            'pronostico' => 'required|string|max:500',

            // Tratamiento e indicaciones médicas (como strings concatenados)
            'manejo_dieta' => 'nullable|string|max:2000',
            'manejo_soluciones' => 'nullable|string|max:2000',
            'manejo_medicamentos' => 'nullable|string|max:2000',
            'manejo_laboratorios' => 'nullable|string|max:2000',
            'manejo_medidas_generales' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'evolucion_actualizacion.required' => 'La evolución y actualización es obligatoria.',
            'ta.required' => 'La tensión arterial es obligatoria.',
            'fc.required' => 'La frecuencia cardíaca es obligatoria.',
            'fc.numeric' => 'La frecuencia cardíaca debe ser un número.',
            'fr.required' => 'La frecuencia respiratoria es obligatoria.',
            'temp.required' => 'La temperatura es obligatoria.',
            'peso.required' => 'El peso es obligatorio.',
            'talla.required' => 'La talla es obligatoria.',
            'diagnostico_problema_clinico.required' => 'El diagnóstico y problema clínico es obligatorio.',
            'pronostico.required' => 'El pronóstico es obligatorio.',
            // Agrega más si necesitas para campos específicos
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'evolucion_actualizacion' => 'Evolución y Actualización',
            'ta' => 'Tensión Arterial',
            'fc' => 'Frecuencia Cardíaca',
            'fr' => 'Frecuencia Respiratoria',
            'temp' => 'Temperatura',
            'peso' => 'Peso',
            'talla' => 'Talla',
            'resultados_relevantes' => 'Resultados Relevantes',
            'diagnostico_problema_clinico' => 'Diagnóstico y Problema Clínico',
            'pronostico' => 'Pronóstico',
            'manejo_dieta' => 'Manejo de dieta',
            'manejo_soluciones' => 'Manejo de Soluciones',
            'manejo_medicamentos' => 'Manejo de Medicamentos',
            'manejo_laboratorios' => 'Manejo de Laboratorios',
            'manejo_medidas_generales' => 'Manejo de Medidas Generales',
        ];
    }
}