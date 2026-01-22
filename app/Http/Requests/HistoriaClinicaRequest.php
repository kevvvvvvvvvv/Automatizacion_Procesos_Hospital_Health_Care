<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaClinicaRequest extends FormRequest
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
            'padecimiento_actual'     => ['required', 'string', 'min:5', 'max:10000'],
            'resultados_previos'      => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico'             => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'              => ['required', 'string', 'min:5', 'max:10000'],
            'indicacion_terapeutica'  => ['required', 'string', 'min:5', 'max:10000'],

            'tension_arterial'        => ['required', 'string', 'min:5', 'max:20'], 
            'frecuencia_cardiaca'     => ['required', 'integer', 'between:0,300'],
            'frecuencia_respiratoria' => ['required', 'integer', 'between:0,100'], 
            'temperatura'             => ['required', 'numeric', 'between:30,45'], 
            'peso'                    => ['required', 'numeric', 'between:0.1,600'], 
            'talla'                   => ['required', 'integer', 'between:20,300'], 
            'respuestas'              => ['required', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            // Padecimiento Actual
            'padecimiento_actual.required' => 'El padecimiento actual es obligatorio.',
            'padecimiento_actual.min'      => 'El padecimiento actual debe tener al menos 5 caracteres.',
            'padecimiento_actual.max'      => 'El padecimiento actual es demasiado extenso.',

            // Tensión Arterial
            'tension_arterial.required' => 'La tensión arterial es obligatoria.',
            'tension_arterial.max'      => 'La tensión arterial no debe exceder los 20 caracteres.',
            'tension_arterial.min'      => 'La tensión arterial parece incompleta (ej. 120/80).',

            // Frecuencia Cardíaca
            'frecuencia_cardiaca.required' => 'La frecuencia cardíaca es obligatoria.',
            'frecuencia_cardiaca.integer'  => 'La frecuencia cardíaca debe ser un número entero.',
            'frecuencia_cardiaca.between'  => 'La frecuencia cardíaca debe estar entre 0 y 300 lpm.',

            // Frecuencia Respiratoria
            'frecuencia_respiratoria.required' => 'La frecuencia respiratoria es obligatoria.',
            'frecuencia_respiratoria.integer'  => 'La frecuencia respiratoria debe ser un número entero.',
            'frecuencia_respiratoria.between'  => 'La frecuencia respiratoria debe estar entre 0 y 100 rpm.',

            // Temperatura
            'temperatura.required' => 'La temperatura es obligatoria.',
            'temperatura.numeric'  => 'La temperatura debe ser un valor numérico.',
            'temperatura.between'  => 'La temperatura debe estar en un rango válido (30°C - 45°C).',

            // Peso
            'peso.required' => 'El peso es obligatorio.',
            'peso.numeric'  => 'El peso debe ser un valor numérico.',
            'peso.between'  => 'El peso debe ser un valor lógico (entre 0.1kg y 600kg).',

            // Talla
            'talla.required' => 'La talla es obligatoria.',
            'talla.integer'  => 'La talla debe ser un número entero (cm).',
            'talla.between'  => 'La talla debe estar entre 20 cm y 300 cm.',

            // Textos largos (Resultados, Diagnóstico, Pronóstico, Indicaciones)
            'resultados_previos.required'      => 'Los resultados previos son obligatorios.',
            'resultados_previos.min'           => 'Describa los resultados previos con más detalle.',
            
            'diagnostico.required'             => 'El diagnóstico es obligatorio.',
            'diagnostico.min'                  => 'El diagnóstico debe ser más descriptivo.',
            
            'pronostico.required'              => 'El pronóstico es obligatorio.',
            'pronostico.min'                   => 'El pronóstico debe ser más descriptivo.',
            
            'indicacion_terapeutica.required'  => 'La indicación terapéutica es obligatoria.',
            'indicacion_terapeutica.min'       => 'La indicación terapéutica debe ser más detallada.',

            // Respuestas
            'respuestas.required' => 'Es necesario proporcionar las respuestas del formulario.',
            'respuestas.array'    => 'El formato de las respuestas no es válido.',
        ];
    }
}
