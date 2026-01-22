<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaUrgenciaRequest extends FormRequest
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
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'],
            'fr'    => ['required', 'integer', 'between:0,100'],
            'temp'  => ['required', 'numeric', 'between:30,45'],
            'peso'  => ['required', 'numeric', 'between:0.1,600'],
            'talla' => ['required', 'integer', 'between:20,300'],

            'motivo_atencion'                => ['required', 'string', 'min:5', 'max:10000'],
            'resumen_interrogatorio'         => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'             => ['required', 'string', 'min:5', 'max:10000'],
            'estado_mental'                  => ['required', 'string', 'min:5', 'max:10000'],
            'resultados_relevantes'          => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'tratamiento'                    => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                     => ['required', 'string', 'min:5', 'max:10000'],
        ];
    }

    public function messages(): array
    {
        return [
            // --- SIGNOS VITALES ---
            'ta.required'    => 'La tensión arterial es obligatoria.',
            'ta.max'         => 'La tensión arterial es muy larga (ej. 120/80).',
            
            'fc.required'    => 'La frecuencia cardíaca es obligatoria.',
            'fc.integer'     => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.between'     => 'La frecuencia cardíaca debe estar entre 0 y 300.',
            
            'fr.required'    => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'     => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.between'     => 'La frecuencia respiratoria debe estar entre 0 y 100.',
            
            'temp.required'  => 'La temperatura es obligatoria.',
            'temp.numeric'   => 'La temperatura debe ser un valor numérico.',
            'temp.between'   => 'La temperatura debe estar entre 30 y 45 grados.',
            
            'peso.required'  => 'El peso es obligatorio.',
            'peso.numeric'   => 'El peso debe ser un valor numérico.',
            'peso.between'   => 'El peso debe estar entre 0.1 y 600 kg.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.integer'  => 'La talla debe ser un número entero (cm).',
            'talla.between'  => 'La talla debe estar entre 20 y 300 cm.',

            // --- MOTIVO DE ATENCIÓN ---
            'motivo_atencion.required' => 'El motivo de atención es obligatorio.',
            'motivo_atencion.min'      => 'El motivo de atención debe tener al menos 5 caracteres.',
            'motivo_atencion.max'      => 'El motivo de atención es demasiado extenso.',

            // --- RESUMEN INTERROGATORIO ---
            'resumen_interrogatorio.required' => 'El resumen del interrogatorio es obligatorio.',
            'resumen_interrogatorio.min'      => 'El resumen del interrogatorio debe ser más detallado (mínimo 5 caracteres).',
            'resumen_interrogatorio.max'      => 'El resumen del interrogatorio es demasiado extenso.',

            // --- EXPLORACIÓN FÍSICA ---
            'exploracion_fisica.required' => 'La exploración física es obligatoria.',
            'exploracion_fisica.min'      => 'La exploración física debe ser más detallada (mínimo 5 caracteres).',
            'exploracion_fisica.max'      => 'La exploración física es demasiado extensa.',

            // --- ESTADO MENTAL ---
            'estado_mental.required' => 'El estado mental es obligatorio.',
            'estado_mental.min'      => 'La descripción del estado mental es muy corta.',
            'estado_mental.max'      => 'La descripción del estado mental es demasiado extensa.',

            // --- RESULTADOS RELEVANTES ---
            'resultados_relevantes.required' => 'Los resultados relevantes son obligatorios.',
            'resultados_relevantes.min'      => 'Describa los resultados con más detalle.',
            'resultados_relevantes.max'      => 'Los resultados relevantes son demasiado extensos.',

            // --- DIAGNÓSTICO ---
            'diagnostico_problemas_clinicos.required' => 'El diagnóstico es obligatorio.',
            'diagnostico_problemas_clinicos.min'      => 'El diagnóstico debe ser más descriptivo.',
            'diagnostico_problemas_clinicos.max'      => 'El diagnóstico es demasiado extenso.',

            // --- TRATAMIENTO ---
            'tratamiento.required' => 'El tratamiento es obligatorio.',
            'tratamiento.min'      => 'El tratamiento debe ser más detallado.',
            'tratamiento.max'      => 'El tratamiento es demasiado extenso.',

            // --- PRONÓSTICO ---
            'pronostico.required' => 'El pronóstico es obligatorio.',
            'pronostico.min'      => 'El pronóstico debe ser más detallado.',
            'pronostico.max'      => 'El pronóstico es demasiado extenso.',
        ];
    }
}