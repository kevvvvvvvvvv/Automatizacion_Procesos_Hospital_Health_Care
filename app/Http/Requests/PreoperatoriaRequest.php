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

            // --- Signos vitales ---
            'ta'   => ['nullable', 'string', 'max:50'],
            'fc'   => ['nullable', 'numeric'],
            'fr'   => ['nullable', 'numeric'],
            'peso' => ['nullable', 'numeric'],
            'talla'=> ['nullable', 'numeric'],
            'temp' => ['nullable', 'numeric'],

            // --- Estudios y exploración ---
            'resultado_estudios' => ['nullable', 'string'],
            'resumen_del_interrogatorio' => ['nullable', 'string'],
            'exploracion_fisica' => ['nullable', 'string'],
            'diagnostico_o_problemas_clinicos' => ['nullable', 'string'],
            'plan_de_estudio' => ['nullable', 'string'],

            // --- Pronóstico ---
            'pronostico' => ['nullable', 'string'],

            // --- Información Preoperatoria ---
            'fecha_cirugia' => ['required', 'date'],
            'diagnostico_preoperatorio' => ['required', 'string', 'max:255'],
            'plan_quirurgico' => ['nullable', 'string'],
            'tipo_intervencion_quirurgica' => ['nullable', 'string'],
            'riesgo_quirurgico' => ['nullable', 'string'],
            'observaciones_riesgo' => ['nullable', 'string'],
            'cuidados_plan_preoperatorios' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            // Signos vitales
            'ta.string' => 'La tensión arterial debe ser texto.',
            'fc.numeric' => 'La frecuencia cardíaca debe ser número.',
            'fr.numeric' => 'La frecuencia respiratoria debe ser número.',
            'peso.numeric' => 'El peso debe ser número.',
            'talla.numeric'=> 'La talla debe ser número.',
            'temp.numeric' => 'La temperatura debe ser número.',

            // Estudios
            'resultado_estudios.string' => 'El resultado de estudios debe ser texto.',
            'resumen_del_interrogatorio.string' => 'El resumen debe ser texto.',
            'exploracion_fisica.string' => 'La exploración física debe ser texto.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico debe ser texto.',
            'plan_de_estudio.string' => 'El plan de estudio debe ser texto.',
            'pronostico' => 'El pronostico debe ser texto',

            // Preoperatoria
            'fecha_cirugia.required' => 'La fecha de cirugía es obligatoria.',
            'fecha_cirugia.date' => 'La fecha de cirugía debe tener un formato válido.',
            'diagnostico_preoperatorio.required' => 'El diagnóstico preoperatorio es obligatorio.',
            'diagnostico_preoperatorio.string' => 'Debe ser texto.',
            'riesgo_quirurgico.string' => 'El riesgo quirúrgico debe ser texto.',
            'observaciones_riesgo.string' => 'Las observaciones deben ser texto.',
            'cuidados_plan_preoperatorios.string' => 'Los cuidados deben ser texto.',
        ];
    }
}
