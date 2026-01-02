<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DietaRequest extends FormRequest
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
            'categoria_dieta_id' => ['required', 'exists:categoria_dietas,id'],
            'alimento' => ['required', 'string', 'min:3', 'max:1000'],
            'costo' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_dieta_id.required' => 'Es obligatorio seleccionar una categoría de dieta.',
            'categoria_dieta_id.exists'   => 'La categoría seleccionada no es válida o no existe en el sistema.',

            'alimento.required' => 'Debes escribir la descripción del alimento o menú.',
            'alimento.string'   => 'La descripción debe ser texto.',
            'alimento.min'      => 'La descripción es muy corta, detalla un poco más.',
            'alimento.max'      => 'La descripción es demasiado larga (máximo 1000 caracteres).',

            
            'costo.required' => 'El precio del alimento es obligatorio.',
            'costo.numeric'  => 'El precio debe ser un número válido.',
            'costo.min'      => 'El precio no puede ser negativo.',
        ];
    }    
}
