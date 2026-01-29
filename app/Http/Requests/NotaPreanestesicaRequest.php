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
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'], 
            'fr'    => ['required', 'integer', 'between:0,100'], 
            'temp'  => ['required', 'numeric', 'between:30,45'], 
            'peso'  => ['required', 'numeric', 'between:0.1,600'], 
            'talla' => ['required', 'integer', 'between:20,300'], 

            'resultado_estudios'               => ['required', 'string', 'min:5', 'max:10000'],
            'resumen_del_interrogatorio'       => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'               => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'plan_de_estudio'                  => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                       => ['required', 'string', 'min:5', 'max:10000'],
            'tratamiento'                      => ['required', 'string', 'min:5', 'max:10000'],

            'plan_estudios_tratamiento'    => ['required', 'string', 'min:5', 'max:10000'],
            'evaluacion_clinica'           => ['required', 'string', 'min:5', 'max:10000'],
            'plan_anestesico'              => ['required', 'string', 'min:5', 'max:10000'],
            'valoracion_riesgos'           => ['required', 'string', 'min:5', 'max:10000'],
            'indicaciones_recomendaciones' => ['required', 'string', 'min:5', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser texto.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            
            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'min'     => 'El campo :attribute es muy corto (mínimo :min caracteres).',
            'max'     => 'El campo :attribute es demasiado extenso (máximo :max caracteres).',

            'ta.max' => 'La tensión arterial debe ser breve (ej. 120/80).',
        ];
    }

    public function attributes(): array
    {
        return [
            // --- Signos Vitales ---
            'ta'    => 'tensión arterial',
            'fc'    => 'frecuencia cardíaca',
            'fr'    => 'frecuencia respiratoria',
            'temp'  => 'temperatura',
            'peso'  => 'peso',
            'talla' => 'talla',

            // --- Estudios y Exploración ---
            'resultado_estudios'               => 'resultados de estudios',
            'resumen_del_interrogatorio'       => 'resumen del interrogatorio',
            'exploracion_fisica'               => 'exploración física',
            'diagnostico_o_problemas_clinicos' => 'diagnóstico',
            'plan_de_estudio'                  => 'plan de estudio',
            'pronostico'                       => 'pronóstico',
            'tratamiento'                      => 'tratamiento',

            // --- Sección Preanestésica ---
            'plan_estudios_tratamiento'    => 'plan de estudios y tratamiento',
            'evaluacion_clinica'           => 'evaluación clínica',
            'plan_anestesico'              => 'plan anestésico',
            'valoracion_riesgos'           => 'valoración de riesgos',
            'indicaciones_recomendaciones' => 'indicaciones y recomendaciones',
        ];
    }
}