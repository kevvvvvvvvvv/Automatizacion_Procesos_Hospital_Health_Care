<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaDietaRequest extends FormRequest
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
            'dieta_id' => 'required|numeric|exists:dietas,id',
            'observaciones' => 'nullable|string|min:0|max:255' 
        ];
    }

    public function messages()
    {
        return [
            'dieta_id.required' => 'La dieta es requerida',
            'dieta_id.numeric' => 'La dieta debe de ser numérica',
            'observaciones.string' => 'Las observaciones tienen que ser un texto',
            'observaciones.max' => 'Las observaciones no deben superar los 255 caracteres',
        ];  
    }
}
