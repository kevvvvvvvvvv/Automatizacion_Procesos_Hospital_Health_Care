<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreoperatoriaRequest extends FormRequest
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
            'diagnostico_preoperatorio' => 'required|string|max:255',
            'fecha_cirugia' => 'required|date',
            'plan_quirurgico' => 'nullable|string',
            'tipo_intervencion_quirurgica' => 'nullable|string',
           'riesgo_quirurgico' => 'required|string',
            'cuidados_plan_preoperatorios' => 'nullable|string',
            'pronostico' => 'nullable|string',
            
        ];
    }
}