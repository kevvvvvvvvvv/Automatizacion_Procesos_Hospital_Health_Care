<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaPostanestesicaRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // ---- Signos Vitales ----
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'], 
            'fr'    => ['required', 'integer', 'between:0,100'], 
            'temp'  => ['required', 'numeric', 'between:30,45'],    
            'peso'  => ['required', 'numeric', 'between:0.1,600'], 
            'talla' => ['required', 'integer', 'between:20,300'],  

            // ---- Campos Clínicos (Text - Max 10000) ----
            'resumen_del_interrogatorio'     => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'             => ['required', 'string', 'min:5', 'max:10000'],
            'resultado_estudios'             => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'plan_de_estudio'                => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                     => ['required', 'string', 'min:5', 'max:10000'],

            // ---- Campos de Anestesia (Text - Max 10000) ----
            'tecnica_anestesica'     => ['required', 'string', 'min:5', 'max:10000'],
            'farmacos_administrados' => ['required', 'string', 'min:5', 'max:10000'],
            'incidentes_anestesia'   => ['required', 'string', 'min:5', 'max:10000'], 
            'balance_hidrico'        => ['required', 'string', 'min:5', 'max:10000'],
            'estado_clinico'         => ['required', 'string', 'min:5', 'max:10000'], 
            'plan_manejo'            => ['required', 'string', 'min:5', 'max:10000'],

            // Formato de hora (acepta HH:MM o HH:MM:SS)
            'duracion_anestesia'     => ['required', 'date_format:H:i,H:i:s'],
        ];
    }

    public function attributes(): array
    {
        return [
            // Signos Vitales
            'ta'    => 'tensión arterial',
            'fc'    => 'frecuencia cardíaca',
            'fr'    => 'frecuencia respiratoria',
            'temp'  => 'temperatura',
            'peso'  => 'peso',
            'talla' => 'talla',

            // Clínicos
            'resumen_del_interrogatorio'       => 'resumen del interrogatorio',
            'exploracion_fisica'               => 'exploración física',
            'resultado_estudios'               => 'resultados de estudios',
            'diagnostico_o_problemas_clinicos' => 'diagnóstico y problemas clínicos',
            'plan_de_estudio'                  => 'plan de estudio',
            'pronostico'                       => 'pronóstico',

            // Anestesia
            'tecnica_anestesica'     => 'técnica anestésica',
            'farmacos_administrados' => 'fármacos administrados',
            'duracion_anestesia'     => 'duración de la anestesia',
            'incidentes_anestesia'   => 'incidentes durante la anestesia',
            'balance_hidrico'        => 'balance hídrico',
            'estado_clinico'         => 'estado clínico',
            'plan_manejo'            => 'plan de manejo',
        ];
    }

    public function messages(): array
    {
        return [
            // Mensajes Generales
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser texto.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            
            // Mensajes de Rango y Longitud
            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'min'     => 'El campo :attribute es muy corto (mínimo :min caracteres).',
            'max'     => 'El campo :attribute es demasiado extenso (máximo :max caracteres).',

            // Mensajes Específicos
            'duracion_anestesia.date_format' => 'La duración debe tener el formato de hora (HH:MM).',
            'ta.max' => 'La tensión arterial debe ser breve (ej. 120/80).',
        ];
    }
}
