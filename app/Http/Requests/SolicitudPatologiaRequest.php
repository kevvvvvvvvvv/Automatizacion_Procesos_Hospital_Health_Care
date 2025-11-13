<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudPatologiaRequest extends FormRequest
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
            'estudio_solicitado' => 'required|string|max:255',
            'datos_clinicos' => 'required|string',
            'pieza_remitida' => 'required|string|max:255',

            'biopsia_pieza_quirurgica' => 'nullable|string|max:255',
            'revision_laminillas' => 'nullable|string|max:255',
            'estudios_especiales' => 'nullable|string|max:255',
            'pcr' => 'nullable|string|max:255',
            'user_solicita_id' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha_estudio.required' => 'Debe seleccionar la fecha del estudio.',
            'fecha_estudio.date' => 'El formato de la fecha del estudio no es válido.',

            'estudio_solicitado.required' => 'El campo "estudio solicitado" es obligatorio.',
            'estudio_solicitado.string' => 'El campo "estudio solicitado" debe ser texto.',
            'estudio_solicitado.max' => 'El campo "estudio solicitado" es demasiado largo (máx. 255 caracteres).',

            'pieza_remitida.required' => 'Debe especificar la "pieza que se remitirá" (ej. Riñón derecho).',
            'pieza_remitida.string' => 'El campo "pieza remitida" debe ser texto.',
            'pieza_remitida.max' => 'El campo "pieza remitida" es demasiado largo (máx. 255 caracteres).',

            'datos_clinicos.required' => 'Los "datos clínicos" (diagnóstico) son obligatorios.',
            'datos_clinicos.string' => 'Los "datos clínicos" deben ser texto.',

            'biopsia_pieza_quirurgica.string' => 'El campo "biopsia o pieza" debe ser texto.',
            'biopsia_pieza_quirurgica.max' => 'El campo "biopsia o pieza" es demasiado largo.',
            
            'revision_laminillas.string' => 'El campo "revisión de laminillas" debe ser texto.',
            'revision_laminillas.max' => 'El campo "revisión de laminillas" es demasiado largo.',

            'estudios_especiales.string' => 'El campo "estudios especiales" debe ser texto.',
            'estudios_especiales.max' => 'El campo "estudios especiales" es demasiado largo.',

            'pcr.string' => 'El campo "PCR" debe ser texto.',
            'pcr.max' => 'El campo "PCR" es demasiado largo.',

            'user_solicita_id.required' => 'El medico que solicita es obligatorio',
            'user_solicita_id.numeric' => 'El medico debe tener un ID',
        ];
    }
}
