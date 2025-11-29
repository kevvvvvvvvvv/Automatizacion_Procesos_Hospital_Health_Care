<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InterconsultasRequest extends FormRequest
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
            'ta' => ['string'],
            'fc' => ['integer', 'min:0'],
            'fr' => ['integer', 'min:0'],
            'temp' => ['numeric', 'min:20'],
            'peso' => ['numeric', 'min:0'],
            'talla' => ['numeric', 'min:0'],
            'criterio_diagnostico' => ['string'],
            'plan_de_estudio' => ['string'],
            'sugerencia_diagnostica' => ['string'],
            'resumen_del_interrogatorio' => ['string'],
            'exploracion_fisica' => ['string'],
            'estado_mental' => ['string'],
            'resultados_relevantes_del_estudio_diagnostico' => ['string'],
            'tratamiento' => ['string'],
            'pronostico' =>['string'],
            'motivo_de_la_atencion_o_interconsulta' => ['required', 'string'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string'],
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
            // --- T.A. (Tensión Arterial) ---
            'ta.string' => 'La tensión arterial debe ser un texto.',

            // --- Frecuencia Cardíaca ---
            'fc.integer' => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.min' => 'La frecuencia cardíaca no puede ser un valor negativo.',

            // --- Frecuencia Respiratoria ---
            'fr.integer' => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.min' => 'La frecuencia respiratoria no puede ser un valor negativo.',

            // --- Temperatura ---
            'temp.numeric' => 'La temperatura debe ser un valor numérico.',
            'temp.min' => 'La temperatura no puede ser menor a 20.',

            // --- Peso ---
            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'peso.min' => 'El peso no puede ser un valor negativo.',

            // --- Talla ---
            'talla.numeric' => 'La talla debe ser un valor numérico.',
            'talla.min' => 'La talla no puede ser un valor negativo.',

            // --- Criterio Diagnóstico ---
            'criterio_diagnostico.string' => 'El criterio diagnóstico debe ser un texto.',

            // --- Plan de Estudio ---
            'plan_de_estudio.string' => 'El plan de estudio debe ser un texto.',

            // --- Sugerencia Diagnóstica ---
            'sugerencia_diagnostica.string' => 'La sugerencia diagnóstica debe ser un texto.',

            // --- Resumen del Interrogatorio ---
            'resumen_del_interrogatorio.string' => 'El resumen del interrogatorio debe ser un texto.',

            // --- Exploración Física ---
            'exploracion_fisica.string' => 'La exploración física debe ser un texto.',

            // --- Estado Mental ---
            'estado_mental.string' => 'El estado mental debe ser un texto.',

            // --- Resultados Relevantes del Estudio Diagnóstico ---
            'resultados_relevantes_del_estudio_diagnostico.string' => 'Los resultados relevantes del estudio diagnóstico deben ser un texto.',

            // --- Tratamiento y Pronóstico ---
            'tratamiento.string' => 'El tratamiento deben ser un texto.',
            'pronostico.string' => 'EL pronóstico deben ser un texto',
            // --- Motivo de la Atención o Interconsulta ---
            'motivo_de_la_atencion_o_interconsulta.required' => 'El motivo de la atención o interconsulta es obligatorio.',
            'motivo_de_la_atencion_o_interconsulta.string' => 'El motivo de la atención o interconsulta debe ser un texto.',

            // --- Diagnóstico o Problemas Clínicos ---
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico o problemas clínicos es obligatorio.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico o problemas clínicos debe ser un texto.',
        ];
    }
}