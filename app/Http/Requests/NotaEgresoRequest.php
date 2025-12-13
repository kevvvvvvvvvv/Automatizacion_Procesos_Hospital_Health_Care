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
            'motivo_egreso' => 'required|string',
            'motivo_egreso_otro' => 'nullable|string|required_if:motivo_egreso,otro',
            'diagnosticos_finales' => 'required|string|max:1000', 
            'resumen_evolucion_estado_actual' => 'required|string|max:1000',
            'manejo_durante_estancia' => 'required|string|max:1000',
            'problemas_pendientes' => 'required|string|max:1000',
            'plan_manejo_tratamiento' => 'required|string|max:1000',
            'recomendaciones' => 'required|string|max:1000',
            'factores_riesgo' => 'required|string|max:1000',
            'pronostico' => 'required|string|max:1000',
            'defuncion' => 'nullable|string|max:1000', 
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
            'diagnosticos_finales.required' => 'Los diagnósticos finales son obligatorios.',
            'resumen_evolucion_estado_actual.required' => 'El resumen de evolución es obligatorio.',
            'manejo_durante_estancia.required' => 'El manejo durante la estancia es obligatorio.',
            'problemas_pendientes.required' => 'Debe especificar los problemas pendientes.',
            'plan_manejo_tratamiento.required' => 'El plan de manejo y tratamiento es obligatorio.',
            'recomendaciones.required' => 'Las recomendaciones son obligatorias.',
            'factores_riesgo.required' => 'Debe especificar los factores de riesgo.',

            // Pronóstico
            'pronostico.required' => 'El pronóstico es obligatorio.',

            //Defunción
            'defuncion.required_if' => 'Debe proporcionar información adicional en caso de defunción.',
        ];
    }
}
