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
            // ---- Evolución (Texto principal) ----
            'evolucion_actualizacion' => ['required', 'string', 'min:10', 'max:5000'],

            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'],
            'fr'    => ['required', 'integer', 'between:0,100'],
            'temp'  => ['required', 'numeric', 'between:30,45'],
            'peso'  => ['required', 'numeric', 'between:0.1,600'],
            'talla' => ['required', 'numeric', 'between:20,300'], 

            // ---- Campos Clínicos (Textos) ----
            'resultado_estudios'               => ['required', 'string', 'min:5', 'max:5000'],
            'resumen_del_interrogatorio'       => ['required', 'string', 'min:5', 'max:5000'],
            'exploracion_fisica'               => ['required', 'string', 'min:5', 'max:5000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:5000'],
            'plan_de_estudio'                  => ['required', 'string', 'min:5', 'max:5000'],
            'pronostico'                       => ['required', 'string', 'min:5', 'max:5000'],
            'tratamiento'                      => ['required', 'string', 'min:5', 'max:5000'],

            // ---- Manejo e Indicaciones (Textos) ----
            'manejo_dieta'             => ['nullable', 'string', 'min:5', 'max:5000'],
            'manejo_soluciones'        => ['nullable', 'string', 'min:5', 'max:5000'],
            'manejo_medicamentos'      => ['nullable', 'string', 'min:5', 'max:5000'],
            'manejo_laboratorios'      => ['nullable', 'string', 'min:5', 'max:5000'],
            'manejo_medidas_generales' => ['nullable', 'string', 'min:5', 'max:5000'],
        ];
    }
    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'evolucion_actualizacion.required' => 'La actualización de la evolución es obligatoria.',
            'evolucion_actualizacion.min'      => 'La evolución debe ser más detallada.',
            'evolucion_actualizacion.max'      => 'El texto de evolución es demasiado extenso.',

            'ta.required'    => 'La tensión arterial es obligatoria.',
            'ta.max'         => 'La tensión arterial es demasiado larga (ej. 120/80).',
            
            'fc.required'    => 'La frecuencia cardíaca es obligatoria.',
            'fc.integer'     => 'La frecuencia cardíaca debe ser un número entero.',
            'fc.between'     => 'La frecuencia cardíaca debe estar entre 0 y 300 lpm.',
            
            'fr.required'    => 'La frecuencia respiratoria es obligatoria.',
            'fr.integer'     => 'La frecuencia respiratoria debe ser un número entero.',
            'fr.between'     => 'La frecuencia respiratoria debe estar entre 0 y 100 rpm.',
            
            'temp.required'  => 'La temperatura es obligatoria.',
            'temp.numeric'   => 'La temperatura debe ser numérica.',
            'temp.between'   => 'La temperatura debe estar entre 30 y 45 °C.',
            
            'peso.required'  => 'El peso es obligatorio.',
            'peso.numeric'   => 'El peso debe ser numérico.',
            'peso.between'   => 'El peso debe estar entre 0.1 y 600 kg.',
            
            'talla.required' => 'La talla es obligatoria.',
            'talla.numeric'  => 'La talla debe ser numérica.',
            'talla.between'  => 'La talla debe estar entre 20 y 300 cm.',

            'resultado_estudios.required'               => 'Los resultados de estudios son obligatorios.',
            'resumen_del_interrogatorio.required'       => 'El resumen del interrogatorio es obligatorio.',
            'exploracion_fisica.required'               => 'La exploración física es obligatoria.',
            'diagnostico_o_problemas_clinicos.required' => 'El diagnóstico o problemas clínicos son obligatorios.',
            'plan_de_estudio.required'                  => 'El plan de estudio es obligatorio.',
            'pronostico.required'                       => 'El pronóstico es obligatorio.',
            'tratamiento.required'                      => 'La descripción del tratamiento es obligatoria.',

            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute no debe exceder los :max caracteres.',

            'manejo_dieta.required'             => 'El manejo de dieta es obligatorio.',
            'manejo_soluciones.required'        => 'El manejo de soluciones es obligatorio.',
            'manejo_medicamentos.required'      => 'El manejo de medicamentos es obligatorio.',
            'manejo_laboratorios.required'      => 'El manejo de laboratorios es obligatorio.',
            'manejo_medidas_generales.required' => 'Las medidas generales son obligatorias.',
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