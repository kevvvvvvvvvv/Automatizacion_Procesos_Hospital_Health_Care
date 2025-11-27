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

            // ---- Signos Vitales ----
            'ta'   => ['nullable', 'string', 'max:255'],
            'fc'   => ['nullable', 'numeric'],
            'fr'   => ['nullable', 'numeric'],
            'temp' => ['nullable', 'numeric'],
            'peso' => ['nullable', 'numeric'],
            'talla'=> ['nullable', 'numeric'],

            // ---- Consulta / Exploración ----
            'resumen_del_interrogatorio'         => ['nullable', 'string'],
            'exploracion_fisica'                 => ['nullable', 'string'],
            'diagnostico_o_problemas_clinicos'   => ['nullable', 'string'],
            'plan_de_estudio'                    => ['nullable', 'string'],
            'pronostico'                         => ['nullable', 'string'],

            // ---- Datos del traslado ----
            'unidad_medica_envia'  => ['required', 'string', 'max:255'],
            'unidad_medica_recibe' => ['required', 'string', 'max:255'],
            'motivo_translado'     => ['required', 'string'],
            'impresion_diagnostica'=> ['nullable', 'string'],
            'terapeutica_empleada' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [

            // ---- Unidad médica ----
            'unidad_medica_envia.required' => 'La unidad médica que envía es obligatoria.',
            'unidad_medica_envia.string'   => 'La unidad médica que envía debe ser una cadena de texto.',
            'unidad_medica_envia.max'      => 'La unidad médica que envía no debe exceder los 255 caracteres.',

            'unidad_medica_recibe.required' => 'La unidad médica que recibe es obligatoria.',
            'unidad_medica_recibe.string'   => 'La unidad médica que recibe debe ser una cadena de texto.',
            'unidad_medica_recibe.max'      => 'La unidad médica que recibe no debe exceder los 255 caracteres.',

            // ---- Motivo de traslado ----
            'motivo_translado.required' => 'El motivo del traslado es obligatorio.',
            'motivo_translado.string'   => 'El motivo del traslado debe ser una cadena de texto.',

            // ---- Signos Vitales ----
            'ta.string' => 'La tensión arterial debe ser una cadena de texto.',
            'ta.max'    => 'La tensión arterial no debe exceder los 255 caracteres.',

            'fc.numeric' => 'La frecuencia cardíaca debe ser un número.',
            'fr.numeric' => 'La frecuencia respiratoria debe ser un número.',
            'temp.numeric' => 'La temperatura debe ser un número.',
            'peso.numeric' => 'El peso debe ser un número.',
            'talla.numeric'=> 'La talla debe ser un número.',

            // ---- Consulta / Exploración ----
            'resumen_del_interrogatorio.string' => 'El resumen del interrogatorio debe ser una cadena de texto.',
            'exploracion_fisica.string' => 'La exploración física debe ser una cadena de texto.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico o problemas clínicos debe ser una cadena de texto.',
            'plan_de_estudio.string' => 'El plan de estudio debe ser una cadena de texto.',
            'pronostico.string' => 'El pronóstico debe ser una cadena de texto.',

            // ---- Traslado extra ----
            'impresion_diagnostica.string' => 'La impresión diagnóstica debe ser una cadena de texto.',
            'terapeutica_empleada.string'  => 'La terapéutica empleada debe ser una cadena de texto.',
        ];
    }
}
