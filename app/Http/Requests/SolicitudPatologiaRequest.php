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
        $detonantesPatologia = 'biopsia_pieza_quirurgica,revision_laminillas,estudios_especiales,pcr,datos_clinicos,empresa_enviar, user_solicita_id, contenedores_enviados';

        return [
            'estudio_solicitado' => [
                'required',
                'required_with:pieza_remitida,' . $detonantesPatologia, 
                'string',
                'max:255'
            ],
            'pieza_remitida' => [
                'required',
                'required_with:estudio_solicitado,' . $detonantesPatologia,
                'string',
                'max:255'
            ],
            'biopsia_pieza_quirurgica' => ['nullable', 'string', 'max:255'],
            'revision_laminillas'      => ['nullable', 'string', 'max:255'],
            'estudios_especiales'      => ['nullable', 'string', 'max:255'],
            'pcr'                      => ['nullable', 'string', 'max:255'],
            'datos_clinicos'           => ['nullable', 'string', 'max:10000'],
            'empresa_enviar'           => ['nullable', 'string', 'max:255'],
            'user_solicita_id'         => ['required', 'numeric'],
            'contenedores_enviados'    => ['required', 'numeric'],
            'itemable_id'              => ['required', 'numeric'],
            'itemable_type'            => ['required', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'required_with' => 'El campo :attribute es requerido cuando se envía :values.',
            'string'   => 'El campo :attribute debe ser una cadena de texto.',
            'max'      => 'El campo :attribute no debe exceder los :max caracteres.',
            'numeric'  => 'El campo :attribute debe ser un número válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            'estudio_solicitado'       => 'estudio solicitado',
            'pieza_remitida'           => 'pieza remitida',
            'biopsia_pieza_quirurgica' => 'biopsia o pieza quirúrgica',
            'revision_laminillas'      => 'revisión de laminillas',
            'estudios_especiales'      => 'estudios especiales',
            'pcr'                      => 'PCR',
            'datos_clinicos'           => 'datos clínicos',
            'empresa_enviar'           => 'empresa a enviar',
            'user_solicita_id'         => 'usuario que solicita',
            'contenedores_enviados'    => 'contenedores enviados',
        ];
    }
}
