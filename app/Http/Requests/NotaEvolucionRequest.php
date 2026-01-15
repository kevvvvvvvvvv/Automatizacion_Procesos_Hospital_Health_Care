<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaEvolucionRequest extends FormRequest
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
            // Evolución y actualización (Obligatorio)
            'evolucion_actualizacion' => ['required', 'string', 'max:2000'],

            // Signos vitales (Obligatorios)
            'ta'    => ['required', 'string', 'max:20'],
            'fc'    => ['required', 'numeric', 'min:0', 'max:300'],
            'fr'    => ['required', 'numeric', 'min:0', 'max:100'],
            'temp'  => ['required', 'numeric', 'min:30', 'max:45'],
            'peso'  => ['required', 'numeric', 'min:0', 'max:500'],
            'talla' => ['required', 'numeric', 'min:0', 'max:300'],

            // Campos clínicos (Obligatorios)
            'resultado_estudios'               => ['required', 'string'],
            'resumen_del_interrogatorio'       => ['required', 'string'],
            'exploracion_fisica'               => ['required', 'string'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string'],
            'plan_de_estudio'                  => ['required', 'string'],
            'pronostico'                       => ['required', 'string'],
            'tratamiento'                      => ['required', 'string'],

            // Manejo e indicaciones médicas (Obligatorios)
            'manejo_dieta'             => ['required', 'string', 'max:2000'],
            'manejo_soluciones'        => ['required', 'string', 'max:2000'],
            'manejo_medicamentos'      => ['required', 'string', 'max:2000'],
            'manejo_laboratorios'      => ['required', 'string', 'max:2000'],
            'manejo_medidas_generales' => ['required', 'string', 'max:2000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            // Requeridos
            'evolucion_actualizacion.required' => 'La evolución y actualización es obligatoria.',
            'ta.required'                      => 'La tensión arterial es obligatoria.',
            'fc.required'                      => 'La frecuencia cardíaca es obligatoria.',
            'fr.required'                      => 'La frecuencia respiratoria es obligatoria.',
            'temp.required'                    => 'La temperatura es obligatoria.',
            'peso.required'                    => 'El peso es obligatorio.',
            'talla.required'                   => 'La talla es obligatoria.',
            
            'resultado_estudios.required'               => 'El resultado de estudios es obligatorio.',
            'resumen_del_interrogatorio.required'       => 'El resumen del interrogatorio es obligatorio.',
            'exploracion_fisica.required'               => 'La exploración física es obligatoria.',
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico es obligatorio.',
            'plan_de_estudio.required'                  => 'El plan de estudio es obligatorio.',
            'pronostico.required'                       => 'El pronóstico es obligatorio.',
            'tratamiento.required'                      => 'El tratamiento es obligatorio.',

            'manejo_dieta.required'             => 'El manejo de dieta es obligatorio.',
            'manejo_soluciones.required'        => 'El manejo de soluciones es obligatorio.',
            'manejo_medicamentos.required'      => 'El manejo de medicamentos es obligatorio.',
            'manejo_laboratorios.required'      => 'El manejo de laboratorios es obligatorio.',
            'manejo_medidas_generales.required' => 'Las medidas generales son obligatorias.',

            // Formatos y tipos
            'ta.string'    => 'La tensión arterial debe ser texto.',
            'fc.numeric'   => 'La frecuencia cardíaca debe ser un número.',
            'fr.numeric'   => 'La frecuencia respiratoria debe ser un número.',
            'temp.numeric' => 'La temperatura debe ser un número.',
            'peso.numeric' => 'El peso debe ser un número.',
            'talla.numeric'=> 'La talla debe ser un número.',
            
            'resultado_estudios.string'               => 'El resultado de estudios debe ser texto.',
            'resumen_del_interrogatorio.string'       => 'El resumen debe ser texto.',
            'tratamiento.string'                      => 'El tratamiento debe ser texto.',
            'exploracion_fisica.string'               => 'La exploración física debe ser texto.',
            'diagnostico_o_problemas_clinicos.string' => 'El diagnóstico debe ser texto.',
            'plan_de_estudio.string'                  => 'El plan de estudio debe ser texto.',
            'pronostico.string'                       => 'El pronóstico debe ser texto.',
            
            // Rangos
            'temp.min' => 'La temperatura no puede ser menor a 30°C.',
            'temp.max' => 'La temperatura no puede ser mayor a 45°C.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'evolucion_actualizacion'          => 'Evolución y Actualización',
            'ta'                               => 'Tensión Arterial',
            'fc'                               => 'Frecuencia Cardíaca',
            'fr'                               => 'Frecuencia Respiratoria',
            'temp'                             => 'Temperatura',
            'peso'                             => 'Peso',
            'talla'                            => 'Talla',
            'diagnostico_o_problemas_clinicos' => 'Diagnóstico y Problema Clínico',
            'manejo_dieta'                     => 'Manejo de dieta',
            'manejo_soluciones'                => 'Manejo de Soluciones',
            'manejo_medicamentos'              => 'Manejo de Medicamentos',
            'manejo_laboratorios'              => 'Manejo de Laboratorios',
            'manejo_medidas_generales'         => 'Manejo de Medidas Generales',
        ];
    }
}