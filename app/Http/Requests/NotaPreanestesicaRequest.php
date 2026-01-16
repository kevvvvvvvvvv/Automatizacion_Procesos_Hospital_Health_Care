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
            // ---- Signos Vitales (Todos Requeridos) ----
            'ta'    => ['required', 'string', 'max:50'],
            'fc'    => ['required', 'numeric'],
            'fr'    => ['required', 'numeric'],
            'peso'  => ['required', 'numeric'],
            'talla' => ['required', 'integer'],
            'temp'  => ['required', 'numeric'],

            // ---- Estudios y Exploración (Todos Requeridos) ----
            'resultado_estudios'               => ['required', 'string'],
            'resumen_del_interrogatorio'       => ['required', 'string'],
            'exploracion_fisica'               => ['required', 'string'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string'],
            'plan_de_estudio'                  => ['required', 'string'],
            'pronostico'                       => ['required', 'string'],
            'tratamiento'                      => ['required', 'string'],

            // ---- Sección Preanestésica (Todos Requeridos) ----
            'plan_estudios_tratamiento'    => ['required', 'string'],
            'evaluacion_clinica'           => ['required', 'string'],
            'plan_anestesico'              => ['required', 'string'],
            'valoracion_riesgos'           => ['required', 'string'],
            'indicaciones_recomendaciones' => ['required', 'string'],
        ];
    }

    /**
     * Mensajes personalizados para la validación.
     */
    public function messages(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta.required' => 'La tensión arterial es obligatoria.',
            'ta.string'   => 'La tensión arterial debe ser una cadena de texto.',
            'ta.max'      => 'La tensión arterial no debe exceder los 50 caracteres.',

            'fc.required' => 'La frecuencia cardíaca es obligatoria.',
            'fc.numeric'  => 'La frecuencia cardíaca debe ser un número.',
            
            'fr.required' => 'La frecuencia respiratoria es obligatoria.',
            'fr.numeric'  => 'La frecuencia respiratoria debe ser un número.',
            
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un número.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.numeric'  => 'La talla debe ser un número.',
            
            'temp.required' => 'La temperatura es obligatoria.',
            'temp.numeric'  => 'La temperatura debe ser un número.',

            // ---- Estudios y Exploración ----
            'resultado_estudios.required'               => 'Los resultados de estudios son obligatorios.',
            'resultado_estudios.string'                 => 'Los resultados de estudios deben ser texto.',
            
            'resumen_del_interrogatorio.required'       => 'El resumen del interrogatorio es obligatorio.',
            'resumen_del_interrogatorio.string'         => 'El resumen del interrogatorio debe ser texto.',
            
            'exploracion_fisica.required'               => 'La exploración física es obligatoria.',
            'exploracion_fisica.string'                 => 'La exploración física debe ser texto.',
            
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico es obligatorio.',
            'diagnostico_o_problemas_clinicos.string'   => 'El diagnóstico debe ser texto.',
            
            'plan_de_estudio.required'                  => 'El plan de estudio es obligatorio.',
            'plan_de_estudio.string'                    => 'El plan de estudio debe ser texto.',
            
            'pronostico.required'                       => 'El pronóstico es obligatorio.',
            'pronostico.string'                         => 'El pronóstico debe ser texto.',
            
            'tratamiento.required'                      => 'El tratamiento es obligatorio.',
            'tratamiento.string'                        => 'El tratamiento debe ser texto.',

            // ---- Nota Preanestésica ----
            'plan_estudios_tratamiento.required'    => 'El plan de estudios y tratamiento es obligatorio.',
            'plan_estudios_tratamiento.string'      => 'El plan de estudios debe ser texto.',
            
            'evaluacion_clinica.required'           => 'La evaluación clínica es obligatoria.',
            'evaluacion_clinica.string'             => 'La evaluación clínica debe ser texto.',
            
            'plan_anestesico.required'              => 'El plan anestésico es obligatorio.',
            'plan_anestesico.string'                => 'El plan anestésico debe ser texto.',
            
            'valoracion_riesgos.required'           => 'La valoración de riesgos (ASA) es obligatoria.',
            'valoracion_riesgos.string'             => 'La valoración de riesgos debe ser texto.',
            
            'indicaciones_recomendaciones.required' => 'Las indicaciones y recomendaciones son obligatorias.',
            'indicaciones_recomendaciones.string'   => 'Las indicaciones deben ser texto.',
        ];
    }
}