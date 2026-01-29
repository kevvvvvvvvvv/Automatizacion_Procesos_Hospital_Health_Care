<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaEgresoRequest extends FormRequest
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
            // --- Motivo de Egreso ---
            'motivo_egreso' => ['required', 'string', 'max:255'],
            
            // Este campo no está en la BD, pero se valida para el formulario
            'motivo_egreso_otro' => ['nullable', 'string', 'max:255', 'required_if:motivo_egreso,Otro,otro'],

            // --- Campos de Texto Largo (TEXT en BD) ---
            'diagnosticos_finales'            => ['required', 'string', 'min:10', 'max:10000'],
            'resumen_evolucion_estado_actual' => ['required', 'string', 'min:10', 'max:10000'],
            'manejo_durante_estancia'         => ['required', 'string', 'min:10', 'max:10000'],
            'problemas_pendientes'            => ['required', 'string', 'min:10', 'max:10000'],
            'plan_manejo_tratamiento'         => ['required', 'string', 'min:10', 'max:10000'],
            'recomendaciones'                 => ['required', 'string', 'min:10', 'max:10000'],
            'factores_riesgo'                 => ['required', 'string', 'min:10', 'max:10000'],
            'pronostico'                      => ['required', 'string', 'min:10', 'max:10000'],

            // --- Campos Opcionales ---
            'defuncion'                       => ['nullable', 'string', 'min:5', 'max:10000'],
        ];
    }

    /**
     * Custom messages for validation
     */
   public function messages(): array
    {
        return [
            // --- Motivo Egreso ---
            'motivo_egreso.required'      => 'Debe seleccionar un motivo de egreso.',
            'motivo_egreso_otro.required_if' => 'Debe especificar el motivo de egreso si seleccionó "Otro".',
            'motivo_egreso_otro.max'      => 'La especificación del motivo es demasiado larga.',

            // --- Diagnósticos ---
            'diagnosticos_finales.required' => 'Los diagnósticos finales son obligatorios.',
            'diagnosticos_finales.min'      => 'Detalle mejor los diagnósticos finales (mínimo 10 caracteres).',
            'diagnosticos_finales.max'      => 'El texto de diagnósticos es demasiado extenso.',

            // --- Resumen Evolución ---
            'resumen_evolucion_estado_actual.required' => 'El resumen de evolución es obligatorio.',
            'resumen_evolucion_estado_actual.min'      => 'El resumen debe ser más detallado.',
            'resumen_evolucion_estado_actual.max'      => 'El resumen es demasiado extenso.',

            // --- Manejo ---
            'manejo_durante_estancia.required' => 'El manejo durante la estancia es obligatorio.',
            'manejo_durante_estancia.min'      => 'Describa el manejo con más detalle.',
            'manejo_durante_estancia.max'      => 'El texto del manejo es demasiado extenso.',

            // --- Problemas Pendientes ---
            'problemas_pendientes.required' => 'Los problemas pendientes son obligatorios (o indique "Ninguno").',
            'problemas_pendientes.min'      => 'Sea más específico con los problemas pendientes.',
            'problemas_pendientes.max'      => 'El texto de problemas pendientes es demasiado extenso.',

            // --- Plan Manejo ---
            'plan_manejo_tratamiento.required' => 'El plan de manejo y tratamiento es obligatorio.',
            'plan_manejo_tratamiento.min'      => 'Detalle el plan de manejo.',
            'plan_manejo_tratamiento.max'      => 'El plan de manejo es demasiado extenso.',

            // --- Recomendaciones ---
            'recomendaciones.required' => 'Las recomendaciones son obligatorias.',
            'recomendaciones.min'      => 'Las recomendaciones deben ser más claras.',
            'recomendaciones.max'      => 'Las recomendaciones son demasiado extensas.',

            // --- Factores Riesgo ---
            'factores_riesgo.required' => 'Los factores de riesgo son obligatorios.',
            'factores_riesgo.min'      => 'Describa los factores de riesgo.',
            'factores_riesgo.max'      => 'El texto de factores de riesgo es demasiado extenso.',

            // --- Pronóstico ---
            'pronostico.required' => 'El pronóstico es obligatorio.',
            'pronostico.min'      => 'Detalle el pronóstico.',
            'pronostico.max'      => 'El pronóstico es demasiado extenso.',

            // --- Defunción ---
            'defuncion.min'       => 'Si hubo defunción, describa las causas con más detalle.',
            'defuncion.max'       => 'La descripción de defunción es demasiado extensa.',
        ];
    }
}
