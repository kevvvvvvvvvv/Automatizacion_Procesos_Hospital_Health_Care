<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SolicitudEstudioRequest extends FormRequest
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
            'diagnostico_problemas' => 'nullable|string',
            'incidentes_accidentes' => 'nullable|string',
           
            'estudios_agregados_ids' => 'array', 
            'estudios_adicionales' => 'array',
            
            'estudios_agregados_ids.*' => 'nullable|integer|exists:catalogo_estudios,id',
            'estudios_adicionales.*' => 'nullable|string|max:255',

            'user_solicita_id' =>'required',
            'detallesEstudios.*' => 'nullable|array' 
        ];
    }

    public function messages()
    {
        return [
            'user_solicita_id.required' => 'El personal que solicita es requerido'
        ];
    }
}


