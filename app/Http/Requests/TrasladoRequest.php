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
            'ta'   => ['required', 'string', 'max:20'], 
            'fc'   => ['required', 'integer', 'between:0,300'], 
            'fr'   => ['required', 'integer', 'between:0,100'], 
            'temp' => ['required', 'numeric', 'between:30,45'], 
            'peso' => ['required', 'numeric', 'between:0.1,600'], 
            'talla'=> ['required', 'integer', 'between:20,300'], 

            'resultado_estudios'               => ['required', 'string', 'min:5', 'max:10000'],
            'resumen_del_interrogatorio'       => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'               => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'plan_de_estudio'                  => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                       => ['required', 'string', 'min:5', 'max:10000'],
            'tratamiento'                      => ['required', 'string', 'min:5', 'max:10000'],
            'motivo_translado'                 => ['required', 'string', 'min:5', 'max:10000'],
            'impresion_diagnostica'            => ['required', 'string', 'min:5', 'max:10000'],

            'unidad_medica_envia'  => ['required', 'string', 'max:255'],
            'unidad_medica_recibe' => ['required', 'string', 'max:255'],
            'terapeutica_empleada' => ['required', 'string', 'max:255'], 
        ];
    }

    public function messages(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta.required' => 'La tensión arterial es obligatoria.',
            'ta.max'      => 'La TA no debe exceder los 20 caracteres (ej: 120/80).',

            'fc.required' => 'La frecuencia cardíaca es obligatoria.',
            'fc.integer'  => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.between'  => 'La frecuencia cardíaca debe estar entre 0 y 300 lpm.',
            
            'fr.required' => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'  => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.between'  => 'La frecuencia respiratoria debe estar entre 0 y 100 rpm.',
            
            'temp.required' => 'La temperatura es obligatoria.',
            'temp.numeric'  => 'La temperatura debe ser un número válido.',
            'temp.between'  => 'La temperatura debe estar entre 30°C y 45°C.',
            
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un número válido.',
            'peso.between'  => 'El peso debe estar entre 0.1 y 600 kg.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.integer'  => 'La talla debe ser un número entero (cm).',
            'talla.between'  => 'La talla debe estar entre 20 y 300 cm.',

            // ---- Validaciones genéricas de texto ----
            'required' => 'Este campo es obligatorio.',
            'string'   => 'Este campo debe ser texto.',
            'min'      => 'El contenido es muy corto, por favor sea más descriptivo.',
            
            // ---- Específicos de longitud ----
            'resultado_estudios.max'               => 'El resultado de estudios es demasiado extenso.',
            'resumen_del_interrogatorio.max'       => 'El resumen del interrogatorio es demasiado extenso.',
            'exploracion_fisica.max'               => 'La exploración física es demasiado extensa.',
            'diagnostico_o_problemas_clinicos.max' => 'El diagnóstico es demasiado extenso.',
            'plan_de_estudio.max'                  => 'El plan de estudio es demasiado extenso.',
            'pronostico.max'                       => 'El pronóstico es demasiado extenso.',
            'tratamiento.max'                      => 'El tratamiento es demasiado extenso.',
            'motivo_translado.max'                 => 'El motivo de traslado es demasiado extenso.',
            'impresion_diagnostica.max'            => 'La impresión diagnóstica es demasiado extensa.',

            // ---- Unidades y Terapéutica (Límite 255) ----
            'unidad_medica_envia.max'  => 'El nombre de la unidad médica (envía) es muy largo (máximo 255).',
            'unidad_medica_recibe.max' => 'El nombre de la unidad médica (recibe) es muy largo (máximo 255).',
            'terapeutica_empleada.max' => 'La terapéutica empleada debe ser breve (máximo 255 caracteres).',
        ];
    }
}