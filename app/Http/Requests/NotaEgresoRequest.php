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

             'motivo_egreso' => 'required|string|in:curacion,mejoria,alta_voluntaria,defuncion,otro',
            'motivo_egreso_otro' => 'nullable|required_if:motivo_egreso,otro|string|max:500',

            // Campos clínicos
            'diagnostico_finales' => 'required|string',
            'resumen_evolucion_estado_actual' => 'required|string',
            'manejo_durante_estancia' => 'required|string',
            'problemas_pendientes' => 'required|string',
            'plan_manejo_tratamiento' => 'required|string',
            'recomendaciones' => 'required|string',
            'factores_riesgo' => 'required|string',

            // Pronóstico obligatorio
            'pronostico' => 'required|string',

            // Defunción: solo obligatorio si motivo_egreso = defuncion
            'defuncion' => 'nullable|required_if:motivo_egreso,defuncion|string',
        ];
    }

    /**
     * Custom messages for validation
     */
    public function messages(): array
    {
        return [

            // Motivo de egreso
            'motivo_egreso.required' => 'El motivo de egreso es obligatorio.',
            'motivo_egreso.in'       => 'El motivo de egreso seleccionado no es válido.',

            // Campo "otro"
            'motivo_egreso_otro.required_if' => 'Debe especificar el motivo de egreso cuando selecciona "Otros".',
            'motivo_egreso_otro.string'      => 'El campo de motivo adicional debe ser texto.',
            'motivo_egreso_otro.max'         => 'El campo de motivo adicional no debe exceder los 500 caracteres.',

            // Campos clínicos
            'diagnostico_finales.required' => 'El diagnóstico final es obligatorio.',
            'resumen_evolucion_estado_actual.required' => 'El resumen de evolución es obligatorio.',
            'manejo_durante_estancia.required' => 'El manejo durante la estancia es obligatorio.',
            'problemas_pendientes.required' => 'Debe especificar los problemas pendientes.',
            'plan_manejo_tratamiento.required' => 'El plan de manejo y tratamiento es obligatorio.',
            'recomendaciones.required' => 'Las recomendaciones son obligatorias.',
            'factores_riesgo.required' => 'Debe especificar los factores de riesgo.',

            // Pronóstico
            'pronostico.required' => 'El pronóstico es obligatorio.',

            // Defunción
            'defuncion.required_if' => 'Debe proporcionar información adicional en caso de defunción.',
        ];
    }
}
