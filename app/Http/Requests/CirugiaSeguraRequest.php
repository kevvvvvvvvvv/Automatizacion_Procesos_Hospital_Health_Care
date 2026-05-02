<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CirugiaSeguraRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */


    public function rules(): array
    {
        return [
            // Textos
            'servicio_procedencia'    => 'required|string|max:255',
            'cirugia_programada'     => 'nullable|string|max:255',
            'cirugia_realizada'      => 'nullable|string|max:255',
            'grupo_rh'               => 'nullable|string|max:10',
            
            // Booleanos (Los que vienen de tu BooleanInput)
            'confirmar_indentidad'   => 'required|boolean',
            'sitio_quirurgico'       => 'required|boolean',
            'funcionamiento_aparatos' => 'required|boolean',
            'oximetro'               => 'required|boolean',
            'via_aerea'             => 'required|boolean',
            'riesgo_hemorragia'       => 'required|boolean',
            'hemoderivados'         => 'required|boolean',
            'profilaxis'            => 'required|boolean',
            'miembros_equipo'       => 'required|boolean',
            'indentidad_paciente'   => 'required|boolean',
            'revision_anestesiologo' => 'required|boolean',
            'esterilizacion'        =>  'required|boolean',
            'dudas_problemas'       => 'required|boolean',
            'imagenes_diagnosticas' => 'required|boolean',
            'nombre_procedimiento'  => 'required|boolean',
            'recuento_instrumentos' => 'required|boolean',
            'faltantes'             => 'required|boolean',
            'etiquedado'            => 'required|boolean',
            // Números
            'tiempo_aproximado'      => 'nullable|integer|min:0',
            'perdida_sanguinea'      => 'nullable|integer|min:0',
            
            // Observaciones largas
            'pasos_criticos'         => 'nullable|string',
            'observaciones'          => 'nullable|string',
            'aspectos_criticos'      => 'nullable|string',
            'alergias'              => 'required|string',
        ];
    }
}

