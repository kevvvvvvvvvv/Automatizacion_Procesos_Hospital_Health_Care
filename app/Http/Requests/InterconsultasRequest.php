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
     */
    public function rules(): array
    {
        return [
            // --- Signos Vitales (Ahora Requeridos) ---
            'ta'    => ['required', 'string'],
            'fc'    => ['required', 'integer', 'min:0'],
            'fr'    => ['required', 'integer', 'min:0'],
            'temp'  => ['required', 'numeric', 'min:20'],
            'peso'  => ['required', 'numeric', 'min:0'],
            'talla' => ['required', 'integer', 'min:0'],

            // --- Información Clínica (Ahora Requeridos) ---
            'criterio_diagnostico'                          => ['required', 'string'],
            'plan_de_estudio'                               => ['required', 'string'],
            'sugerencia_diagnostica'                        => ['required', 'string'],
            'resumen_del_interrogatorio'                    => ['required', 'string'],
            'exploracion_fisica'                            => ['required', 'string'],
            'estado_mental'                                 => ['required', 'string'],
            'resultados_relevantes_del_estudio_diagnostico' => ['required', 'string'],
            'tratamiento'                                   => ['required', 'string'],
            'pronostico'                                    => ['required', 'string'],
            
            // --- Motivo y Diagnóstico ---
            'motivo_de_la_atencion_o_interconsulta'         => ['required', 'string'],
            'diagnostico_o_problemas_clinicos'              => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // --- Signos Vitales ---
            'ta.required'   => 'La tensión arterial es obligatoria.',
            'ta.string'     => 'La tensión arterial debe ser un texto.',
            
            'fc.required'   => 'La frecuencia cardíaca es obligatoria.',
            'fc.integer'    => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.min'        => 'La frecuencia cardíaca no puede ser negativa.',

            'fr.required'   => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'    => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.min'        => 'La frecuencia respiratoria no puede ser negativa.',

            'temp.required' => 'La temperatura es obligatoria.',
            'temp.numeric'  => 'La temperatura debe ser un valor numérico.',
            'temp.min'      => 'La temperatura no puede ser menor a 20.',

            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un valor numérico.',
            'peso.min'      => 'El peso no puede ser negativo.',

            'talla.required'=> 'La talla es obligatoria.',
            'talla.numeric' => 'La talla debe ser un valor numérico.',
            'talla.min'     => 'La talla no puede ser negativa.',

            // --- Información de Interconsulta ---
            'criterio_diagnostico.required'                          => 'El criterio diagnóstico es obligatorio.',
            'plan_de_estudio.required'                               => 'El plan de estudio es obligatorio.',
            'sugerencia_diagnostica.required'                        => 'La sugerencia diagnóstica es obligatoria.',
            'resumen_del_interrogatorio.required'                    => 'El resumen del interrogatorio es obligatorio.',
            'exploracion_fisica.required'                            => 'La exploración física es obligatoria.',
            'estado_mental.required'                                 => 'El estado mental es obligatorio.',
            'resultados_relevantes_del_estudio_diagnostico.required' => 'Los resultados relevantes del estudio son obligatorios.',
            'tratamiento.required'                                   => 'El tratamiento es obligatorio.',
            'pronostico.required'                                    => 'El pronóstico es obligatorio.',

            // --- Motivo y Diagnóstico ---
            'motivo_de_la_atencion_o_interconsulta.required'         => 'El motivo de la atención o interconsulta es obligatorio.',
            'diagnostico_o_problemas_clinicos.required'              => 'El diagnóstico o problemas clínicos es obligatorio.',
            
            // --- Mensajes de Formato ---
            'criterio_diagnostico.string'                          => 'El criterio diagnóstico debe ser un texto.',
            'plan_de_estudio.string'                               => 'El plan de estudio debe ser un texto.',
            'sugerencia_diagnostica.string'                        => 'La sugerencia diagnóstica debe ser un texto.',
            'resumen_del_interrogatorio.string'                    => 'El resumen del interrogatorio debe ser un texto.',
            'exploracion_fisica.string'                            => 'La exploración física debe ser un texto.',
            'estado_mental.string'                                 => 'El estado mental debe ser un texto.',
            'resultados_relevantes_del_estudio_diagnostico.string' => 'Los resultados relevantes deben ser un texto.',
            'tratamiento.string'                                   => 'El tratamiento debe ser un texto.',
            'pronostico.string'                                    => 'El pronóstico debe ser un texto.',
        ];
    }
}