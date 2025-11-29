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
            'ta'    => ['nullable', 'string', 'max:50'],
            'fc'    => ['nullable', 'numeric'],
            'fr'    => ['nullable', 'numeric'],
            'peso'  => ['nullable', 'numeric'],
            'talla' => ['nullable', 'numeric'],
            'temp'  => ['nullable', 'numeric'],

            // --- Estudios y exploración ---
            'resultado_estudios'             => ['nullable', 'string'],
            'resumen_del_interrogatorio'     => ['nullable', 'string'],
            'exploracion_fisica'             => ['nullable', 'string'],
            'diagnostico_o_problemas_clinicos' => ['nullable', 'string'],
            'plan_de_estudio'                => ['nullable', 'string'],

            // --- Pronóstico / tratamiento ---
            'pronostico' => ['nullable', 'string'],
            'tratamiento' => ['nullable', 'string'],

            // --- Información Preoperatoria ---
            'fecha_cirugia'            => ['required', 'date'],
            'diagnostico_preoperatorio'=> ['required', 'string', 'max:255'],
            'plan_quirurgico'          => ['nullable', 'string'],
            'tipo_intervencion_quirurgica' => ['nullable', 'string'],
            'riesgo_quirurgico'        => ['nullable', 'string'], // 👈 AQUI VA TODO
            'cuidados_plan_preoperatorios' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [

            // Signos vitales
            'ta.string'   => 'La tensión arterial debe ser texto.',
            'ta.max'      => 'La tensión arterial no debe exceder los 50 caracteres.',
            'fc.numeric'  => 'La frecuencia cardíaca debe ser un número.',
            'fr.numeric'  => 'La frecuencia respiratoria debe ser un número.',
            'peso.numeric'=> 'El peso debe ser un número.',
            'talla.numeric'=> 'La talla debe ser un número.',
            'temp.numeric'=> 'La temperatura debe ser un número.',

            // Estudios y exploración
            'resultado_estudios.string' => 'El resultado de estudios debe ser texto.',
            'resumen_del_interrogatorio.string' => 'El resumen del interrogatorio debe ser texto.',
            'exploracion_fisica.string' => 'La exploración física debe ser texto.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico o problemas clínicos debe ser texto.',
            'plan_de_estudio.string' => 'El plan de estudio debe ser texto.',

            // Tratamiento
            'pronostico.string' => 'El pronóstico debe ser texto.',
            'tratamiento.string' => 'El tratamiento debe ser texto.',

            // Preoperatoria
            'fecha_cirugia.required' => 'La fecha de cirugía es obligatoria.',
            'fecha_cirugia.date'     => 'La fecha de cirugía debe tener un formato válido.',

            'diagnostico_preoperatorio.required' => 'El diagnóstico preoperatorio es obligatorio.',
            'diagnostico_preoperatorio.string'   => 'Debe ser texto.',
            'diagnostico_preoperatorio.max'      => 'No debe exceder los 255 caracteres.',

            'riesgo_quirurgico.string' => 'La valoración de riesgos debe ser texto.',
            'cuidados_plan_preoperatorios.string' => 'Los cuidados preoperatorios deben ser texto.',
        ];
    }
}
