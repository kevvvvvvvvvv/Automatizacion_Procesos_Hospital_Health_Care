<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaRiesgoCaidaRequest extends FormRequest
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
            'caidas_previas' => 'required|boolean',
            'edad_mayor_70'  => 'required|boolean',
            'estado_mental'  => 'required|string|in:orientado,confuso', 
            'deambulacion'   => 'required|string|in:normal,segura_ayuda,insegura,imposible',
            'medicamentos'   => 'nullable|array',
            'medicamentos.*' => 'string', 
            
            'deficits'       => 'nullable|array',
            'deficits.*'     => 'string',

            'puntaje_total'  => 'required|integer|min:0|max:100', 
        ];
    }


    public function messages(): array
    {
        return [
            'caidas_previas.boolean' => 'El campo caídas previas tiene un formato inválido.',
            'estado_mental.in'       => 'El estado mental seleccionado no es válido.',
            'deambulacion.in'        => 'El tipo de deambulación no es válido.',
            'medicamentos.array'     => 'La lista de medicamentos debe ser un arreglo.',
            'puntaje_total.integer'  => 'El puntaje debe ser un número entero.',
        ];
    }
}
