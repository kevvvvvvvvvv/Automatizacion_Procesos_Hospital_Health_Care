<?php

namespace App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\Isquemia;

use Illuminate\Foundation\Http\FormRequest;

class IsquemiaStoreRequest extends FormRequest
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
            'isquemiable_id' => 'required',
            'isquemiable_type' => 'required',
            'sitio_anatomico' => 'required',
            'hora_inicio' => 'nullable',
            'observaciones' => 'nullable | string',
        ];
    }

    public function attributes()
    {
        return [
            'isquemiable_id' => 'ID del modelo',
            'isquemiable_type' => 'referencia del modelo',
            'observaciones' => 'observaciones',
            'hora_inicio' => 'hora de inicio',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            
        ];
    }

}
