<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreoperatoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // --- Signos vitales (Ahora obligatorios) ---
            'ta'    => ['required', 'string', 'max:50'],
            'fc'    => ['required', 'numeric'],
            'fr'    => ['required', 'numeric'],
            'peso'  => ['required', 'numeric'],
            'talla' => ['required', 'numeric'],
            'temp'  => ['required', 'numeric'],

            // --- Estudios y exploración (Ahora obligatorios) ---
            'resultado_estudios'               => ['required', 'string'],
            'resumen_del_interrogatorio'       => ['required', 'string'],
            'exploracion_fisica'               => ['required', 'string'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string'],
            'plan_de_estudio'                  => ['required', 'string'],

            // --- Pronóstico / tratamiento (Ahora obligatorios) ---
            'pronostico'  => ['required', 'string'],
            'tratamiento' => ['required', 'string'],

            // --- Información Preoperatoria ---
            'fecha_cirugia'                => ['required', 'date'],
            'diagnostico_preoperatorio'    => ['required', 'string', 'max:255'],
            'plan_quirurgico'              => ['required', 'string'],
            'tipo_intervencion_quirurgica' => ['required', 'string'],
            'riesgo_quirurgico'            => ['required', 'string'],
            'cuidados_plan_preoperatorios' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // Signos vitales
            'ta.required'   => 'La tensión arterial es obligatoria.',
            'ta.string'     => 'La tensión arterial debe ser texto.',
            'ta.max'        => 'La tensión arterial no debe exceder los 50 caracteres.',
            'fc.required'   => 'La frecuencia cardíaca es obligatoria.',
            'fc.numeric'    => 'La frecuencia cardíaca debe ser un número.',
            'fr.required'   => 'La frecuencia respiratoria es obligatoria.',
            'fr.numeric'    => 'La frecuencia respiratoria debe ser un número.',
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un número.',
            'talla.required'=> 'La talla es obligatoria.',
            'talla.numeric' => 'La talla debe ser un número.',
            'temp.required' => 'La temperatura es obligatoria.',
            'temp.numeric'  => 'La temperatura debe ser un número.',

            // Estudios y exploración
            'resultado_estudios.required'               => 'El resultado de estudios es obligatorio.',
            'resultado_estudios.string'                 => 'El resultado de estudios debe ser texto.',
            'resumen_del_interrogatorio.required'       => 'El resumen del interrogatorio es obligatorio.',
            'resumen_del_interrogatorio.string'         => 'El resumen del interrogatorio debe ser texto.',
            'exploracion_fisica.required'               => 'La exploración física es obligatoria.',
            'exploracion_fisica.string'                 => 'La exploración física debe ser texto.',
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico o problemas clínicos es obligatorio.',
            'diagnostico_o_problemas_clinicos.string'   => 'El diagnóstico o problemas clínicos debe ser texto.',
            'plan_de_estudio.required'                  => 'El plan de estudio es obligatorio.',
            'plan_de_estudio.string'                    => 'El plan de estudio debe ser texto.',

            // Pronóstico / Tratamiento
            'pronostico.required'  => 'El pronóstico es obligatorio.',
            'pronostico.string'    => 'El pronóstico debe ser texto.',
            'tratamiento.required' => 'El tratamiento es obligatorio.',
            'tratamiento.string'   => 'El tratamiento debe ser texto.',

            // Preoperatoria
            'fecha_cirugia.required' => 'La fecha de cirugía es obligatoria.',
            'fecha_cirugia.date'     => 'La fecha de cirugía debe tener un formato válido.',
            
            'diagnostico_preoperatorio.required' => 'El diagnóstico preoperatorio es obligatorio.',
            'diagnostico_preoperatorio.string'   => 'El diagnóstico debe ser texto.',
            'diagnostico_preoperatorio.max'      => 'El diagnóstico no debe exceder los 255 caracteres.',
            
            'plan_quirurgico.required'              => 'El plan quirúrgico es obligatorio.',
            'tipo_intervencion_quirurgica.required' => 'El tipo de intervención es obligatorio.',
            
            'riesgo_quirurgico.required'            => 'La valoración de riesgos es obligatoria.',
            'riesgo_quirurgico.string'              => 'La valoración de riesgos debe ser texto.',
            
            'cuidados_plan_preoperatorios.required' => 'Los cuidados preoperatorios son obligatorios.',
            'cuidados_plan_preoperatorios.string'   => 'Los cuidados preoperatorios deben ser texto.',
        ];
    }
}