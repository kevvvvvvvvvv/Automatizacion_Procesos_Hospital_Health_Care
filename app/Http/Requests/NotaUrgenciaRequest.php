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
            // --- Signos Vitales (Todos Required) ---
            'ta'    => ['required', 'string'],
            'fc'    => ['required', 'integer', 'min:0'],
            'fr'    => ['required', 'integer', 'min:0'],
            'temp'  => ['required', 'numeric', 'min:20'],
            'peso'  => ['required', 'numeric', 'min:0'],
            'talla' => ['required', 'numeric', 'min:0'],

            // --- Información de la Nota ---
            'motivo_atencion'                => ['required', 'string'],
            'resumen_interrogatorio'         => ['required', 'string'],
            'exploracion_fisica'             => ['required', 'string'],
            'estado_mental'                  => ['required', 'string'],
            'resultados_relevantes'          => ['required', 'string'],
            'diagnostico_problemas_clinicos' => ['required', 'string'],
            'tratamiento'                    => ['required', 'string'],
            'pronostico'                     => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // Signos Vitales
            'ta.required'    => 'La tensión arterial es obligatoria.',
            'ta.string'      => 'La tensión arterial debe ser un texto numérico (ej. 120/80).',
            
            'fc.required'    => 'La frecuencia cardíaca es obligatoria.',
            'fc.integer'     => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.min'         => 'La frecuencia cardíaca no puede ser un valor negativo.',
            
            'fr.required'    => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'     => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.min'         => 'La frecuencia respiratoria no puede ser un valor negativo.',
            
            'temp.required'  => 'La temperatura es obligatoria.',
            'temp.numeric'   => 'La temperatura debe ser un valor numérico.',
            'temp.min'       => 'La temperatura no puede ser menor a 20.',
            
            'peso.required'  => 'El peso es obligatorio.',
            'peso.numeric'   => 'El peso debe ser un valor numérico.',
            'peso.min'       => 'El peso no puede ser un valor negativo.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.numeric'  => 'La talla debe ser un valor numérico.',
            'talla.min'      => 'La talla no puede ser un valor negativo.',

            // Información Clínica
            'motivo_atencion.required'                => 'El motivo de atención es obligatorio.',
            'resumen_interrogatorio.required'         => 'El resumen del interrogatorio es obligatorio.',
            'exploracion_fisica.required'             => 'La exploración física es obligatoria.',
            'estado_mental.required'                  => 'El estado mental es obligatorio.',
            'resultados_relevantes.required'          => 'Los resultados relevantes son obligatorios.',
            'diagnostico_problemas_clinicos.required' => 'El diagnóstico de problemas es obligatorio.',
            'tratamiento.required'                    => 'El tratamiento es obligatorio.',
            'pronostico.required'                     => 'El pronóstico es obligatorio.',

            // Formatos de texto
            'motivo_atencion.string'                => 'El motivo de atención debe ser una cadena de texto.',
            'resumen_interrogatorio.string'         => 'El resumen del interrogatorio debe ser una cadena de texto.',
            'exploracion_fisica.string'             => 'La exploración física debe ser una cadena de texto.',
            'estado_mental.string'                  => 'El estado mental debe ser una cadena de texto.',
            'resultados_relevantes.string'          => 'Los resultados relevantes deben ser una cadena de texto.',
            'diagnostico_problemas_clinicos.string' => 'El diagnóstico de problemas debe ser una cadena de texto.',
            'tratamiento.string'                    => 'El tratamiento debe ser una cadena de texto.',
            'pronostico.string'                     => 'El pronóstico debe ser una cadena de texto.'
        ];
    }
}