<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaPreanestesicaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para la Nota Preanestésica.
     */
    public function rules(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta'    => ['nullable', 'string', 'max:50'],
            'fc'    => ['nullable', 'numeric'],
            'fr'    => ['nullable', 'numeric'],
            'peso'  => ['nullable', 'numeric'],
            'talla' => ['nullable', 'numeric'],
            'temp'  => ['nullable', 'numeric'],

            // ---- Estudios y Exploración ----
            'resultado_estudios'             => ['nullable', 'string'],
            'resumen_del_interrogatorio'     => ['nullable', 'string'],
            'exploracion_fisica'             => ['nullable', 'string'],
            'diagnostico_o_problemas_clinicos' => ['nullable', 'string'],
            'plan_de_estudio'                => ['nullable', 'string'],
            'pronostico'                     => ['nullable', 'string'],

            // ---- Sección Preanestésica ----
            'plan_estudios_tratamiento'      => ['nullable', 'string'],
            'evaluacion_clinica'             => ['nullable', 'string'],
            'plan_anestesico'                => ['nullable', 'string'],
            'valoracion_riesgos'             => ['nullable', 'string'],
            'indicaciones_recomendaciones'   => ['nullable', 'string'],
        ];
    }

    /**
     * Mensajes personalizados para la validación.
     */
    public function messages(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta.string' => 'La tensión arterial debe ser una cadena de texto.',
            'ta.max'    => 'La tensión arterial no debe exceder los 50 caracteres.',

            'fc.numeric' => 'La frecuencia cardíaca debe ser un número.',
            'fr.numeric' => 'La frecuencia respiratoria debe ser un número.',
            'peso.numeric' => 'El peso debe ser un número.',
            'talla.numeric'=> 'La talla debe ser un número.',
            'temp.numeric' => 'La temperatura debe ser un número.',

            // ---- Estudios y Exploración ----
            'resultado_estudios.string' => 'El campo resultados de estudios debe ser una cadena de texto.',
            'resumen_del_interrogatorio.string' => 'El resumen del interrogatorio debe ser una cadena de texto.',
            'exploracion_fisica.string' => 'La exploración física debe ser una cadena de texto.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico debe ser una cadena de texto.',
            'plan_de_estudio.string' => 'El plan de estudio debe ser una cadena de texto.',
            'pronostico.string' => 'El pronóstico debe ser una cadena de texto.',

            // ---- Nota Preanestésica ----
            'plan_estudios_tratamiento.string' => 'El plan de estudios y tratamiento debe ser una cadena de texto.',
            'evaluacion_clinica.string' => 'La evaluación clínica debe ser una cadena de texto.',
            'plan_anestesico.string' => 'El plan anestésico debe ser una cadena de texto.',
            'valoracion_riesgos.string' => 'La valoración de riesgos debe ser una cadena de texto.',
            'indicaciones_recomendaciones.string' => 'Las indicaciones y recomendaciones deben ser una cadena de texto.',
        ];
    }
}
