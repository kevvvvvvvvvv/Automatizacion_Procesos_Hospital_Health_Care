<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrasladoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // ---- Signos Vitales (Todos obligatorios ahora) ----
            'ta'   => ['required', 'string', 'max:255'],
            'fc'   => ['required', 'numeric'],
            'fr'   => ['required', 'numeric'],
            'temp' => ['required', 'numeric'],
            'peso' => ['required', 'numeric'],
            'talla'=> ['required', 'numeric'],

            // ---- Consulta / Exploración (Todos obligatorios ahora) ----
            'resultado_estudios'               => ['required', 'string'],
            'resumen_del_interrogatorio'       => ['required', 'string'],
            'exploracion_fisica'               => ['required', 'string'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string'],
            'plan_de_estudio'                  => ['required', 'string'],
            'pronostico'                       => ['required', 'string'],
            'tratamiento'                      => ['required', 'string'],

            // ---- Datos del traslado ----
            'unidad_medica_envia'  => ['required', 'string', 'max:255'],
            'unidad_medica_recibe' => ['required', 'string', 'max:255'],
            'motivo_translado'     => ['required', 'string'],
            'impresion_diagnostica'=> ['required', 'string'],
            'terapeutica_empleada' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta.required' => 'La tensión arterial (TA) es obligatoria.',
            'ta.string'   => 'La tensión arterial debe ser una cadena de texto.',
            'ta.max'      => 'La tensión arterial no debe exceder los 255 caracteres.',

            'fc.required' => 'La frecuencia cardíaca (FC) es obligatoria.',
            'fc.numeric'  => 'La frecuencia cardíaca debe ser un número.',
            
            'fr.required' => 'La frecuencia respiratoria (FR) es obligatoria.',
            'fr.numeric'  => 'La frecuencia respiratoria debe ser un número.',
            
            'temp.required' => 'La temperatura es obligatoria.',
            'temp.numeric'  => 'La temperatura debe ser un número.',
            
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un número.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.numeric'  => 'La talla debe ser un número.',

            // ---- Consulta / Exploración ----
            'resultado_estudios.required'               => 'Los resultados de estudios son obligatorios.',
            'resultado_estudios.string'                 => 'Los resultados de estudios deben ser texto.',
            
            'resumen_del_interrogatorio.required'       => 'El resumen del interrogatorio es obligatorio.',
            'resumen_del_interrogatorio.string'         => 'El resumen del interrogatorio debe ser texto.',
            
            'exploracion_fisica.required'               => 'La exploración física es obligatoria.',
            'exploracion_fisica.string'                 => 'La exploración física debe ser texto.',
            
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico o problemas clínicos es obligatorio.',
            'diagnostico_o_problemas_clinicos.string'   => 'El diagnóstico debe ser texto.',
            
            'plan_de_estudio.required'                  => 'El plan de estudio es obligatorio.',
            'plan_de_estudio.string'                    => 'El plan de estudio debe ser texto.',
            
            'pronostico.required'                       => 'El pronóstico es obligatorio.',
            'pronostico.string'                         => 'El pronóstico debe ser texto.',
            
            'tratamiento.required'                      => 'El tratamiento es obligatorio.',
            'tratamiento.string'                        => 'El tratamiento debe ser texto.',

            // ---- Unidad médica ----
            'unidad_medica_envia.required'  => 'La unidad médica que envía es obligatoria.',
            'unidad_medica_recibe.required' => 'La unidad médica que recibe es obligatoria.',

            // ---- Traslado ----
            'motivo_translado.required'      => 'El motivo del traslado es obligatorio.',
            'impresion_diagnostica.required' => 'La impresión diagnóstica es obligatoria.',
            'impresion_diagnostica.string'   => 'La impresión diagnóstica debe ser texto.',
            
            'terapeutica_empleada.required'  => 'La terapéutica empleada es obligatoria.',
            'terapeutica_empleada.string'    => 'La terapéutica empleada debe ser texto.',
        ];
    }
}