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
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'min:0', 'max:300'], 
            'fr'    => ['required', 'integer', 'min:0', 'max:100'], 
            'temp'  => ['required', 'numeric', 'between:30,45'],    
            'peso'  => ['required', 'numeric', 'min:0.1', 'max:500'], 
            'talla' => ['required', 'integer', 'min:10', 'max:300'],  

            // Campos de texto (Clínicos)
            'resumen_del_interrogatorio'     => ['required', 'string', 'max:1000'],
            'exploracion_fisica'             => ['required', 'string', 'max:1000'],
            'plan_de_estudio'                => ['required', 'string', 'max:1000'],
            'resultado_estudios'             => ['required', 'string', 'max:1000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'max:1000'],
            'pronostico'                     => ['required', 'string', 'max:255'],
            'tratamiento'                    => ['required', 'string', 'max:255'],
            // Campos de Anestesia
            'tecnica_anestesica'     => ['required', 'string', 'max:255'],
            'farmacos_administrados' => ['required', 'string', 'max:1000'],
            'duracion_anestesia'     => ['required', 'date_format:H:i:s'],
            'incidentes_anestesia'   => ['required', 'string', 'max:1000'], 
            'balance_hidrico'        => ['required', 'string', 'max:255'],
            'estado_clinico'         => ['required', 'string', 'max:255'], 
            'plan_manejo'            => ['required', 'string', 'max:1000'],
        ];
    }


    public function messages(): array
    {
        return [
            'id.required' => 'El identificador del formulario es obligatorio.',
            'id.exists'   => 'El formulario referenciado no existe.',
            
            'ta.required' => 'La tensión arterial es obligatoria.',
            'fc.required' => 'La frecuencia cardiaca es obligatoria.',
            'fc.integer'  => 'La frecuencia cardiaca debe ser un número entero.',
            'fr.required' => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'  => 'La frecuencia respiratoria debe ser un número entero.',
            'temp.required' => 'La temperatura es obligatoria.',
            'peso.required' => 'El peso es obligatorio.',
            'talla.required'=> 'La talla es obligatoria.',

            'resumen_del_interrogatorio.required' => 'El resumen del interrogatorio es obligatorio.',
            'exploracion_fisica.required'         => 'La exploración física es obligatoria.',
            'plan_de_estudio.required'            => 'El plan de estudio es obligatorio.',
            'resultado_estudios.required'         => 'El resultado de estudios de los servicios es requerido',
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico o problemas clínicos son obligatorios.',
            'pronostico.required'                 => 'El pronóstico es obligatorio.',
            'tratamiento.required'                => 'El tratamiento es obliogatorio',

            'tecnica_anestesica.required'     => 'La técnica anestésica es obligatoria.',
            'farmacos_administrados.required' => 'Los fármacos administrados son obligatorios.',
            'duracion_anestesia.required'     => 'La duración de la anestesia es obligatoria.',
            'duracion_anestesia.date_format'  => 'La duración debe tener el formato HH:MM:SS.',
            'balance_hidrico.required'        => 'El balance hídrico es obligatorio.',
            'incidentes_anestesia.required'   => 'Los incidentes de la anestesia es requeridos',
            'estado_clinico.required'         => 'El estado clínico es obligatorio.',
            'plan_manejo.required'            => 'El plan de manejo es obligatorio.',
        ];
    }
}
