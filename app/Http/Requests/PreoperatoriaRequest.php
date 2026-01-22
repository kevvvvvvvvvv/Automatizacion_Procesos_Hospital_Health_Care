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
            
            'fecha_cirugia'                => ['required', 'date'],
            
            'riesgo_quirurgico'            => ['required', 'string', 'max:255'], 
            'tipo_intervencion_quirurgica' => ['required', 'string', 'max:255'],

            
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'], 
            'fr'    => ['required', 'integer', 'between:0,100'], 
            'talla' => ['required', 'integer', 'between:20,300'], 
            'peso'  => ['required', 'numeric', 'between:0.1,600'], 
            'temp'  => ['required', 'numeric', 'between:30,45'],   

            'diagnostico_preoperatorio'    => ['required', 'string', 'min:5', 'max:10000'],
            'plan_quirurgico'              => ['required', 'string', 'min:5', 'max:10000'],
            'cuidados_plan_preoperatorios' => ['required', 'string', 'min:5', 'max:10000'],
            
            'resultado_estudios'               => ['required', 'string', 'min:5', 'max:10000'],
            'resumen_del_interrogatorio'       => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'               => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'plan_de_estudio'                  => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                       => ['required', 'string', 'min:5', 'max:10000'],
            'tratamiento'                      => ['required', 'string', 'min:5', 'max:10000'],
        ];
    }

    public function attributes(): array
    {
        return [

            'ta'    => 'tensión arterial',
            'fc'    => 'frecuencia cardíaca',
            'fr'    => 'frecuencia respiratoria',
            'temp'  => 'temperatura',
            'peso'  => 'peso',
            'talla' => 'talla',


            'fecha_cirugia'                => 'fecha de cirugía',
            'riesgo_quirurgico'            => 'riesgo quirúrgico',
            'tipo_intervencion_quirurgica' => 'tipo de intervención',
            'diagnostico_preoperatorio'    => 'diagnóstico preoperatorio',
            'plan_quirurgico'              => 'plan quirúrgico',
            'cuidados_plan_preoperatorios' => 'cuidados y plan preoperatorios',

            'resultado_estudios'               => 'resultado de estudios',
            'resumen_del_interrogatorio'       => 'resumen del interrogatorio',
            'exploracion_fisica'               => 'exploración física',
            'diagnostico_o_problemas_clinicos' => 'diagnóstico o problemas clínicos',
            'plan_de_estudio'                  => 'plan de estudio',
            'pronostico'                       => 'pronóstico',
            'tratamiento'                      => 'tratamiento',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser texto.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'date'     => 'El campo :attribute debe ser una fecha válida.',

            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'min'     => 'El campo :attribute debe ser más detallado (mínimo :min caracteres).',
            'max'     => 'El campo :attribute es demasiado extenso (máximo :max caracteres).',

            'ta.max' => 'La tensión arterial debe ser breve (ej. 120/80).',
        ];
    }
}