<?php

namespace App\Http\Requests\Formulario\HojaEnfermeriaQuirofano;

use Illuminate\Foundation\Http\FormRequest;

class ConteoMaterialQuirofanoRequest extends FormRequest
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
            'conteo_materiales' => ['required', 'array', 'min:1'],
            
            'conteo_materiales.*.tipo_material' => ['required', 'string', 'max:255'],
            
            'conteo_materiales.*.cantidad_inicial' => [
                'required', 
                'integer', 
                'min:0'
            ],
            
            'conteo_materiales.*.cantidad_agregada' => [
                'required', 
                'integer', 
                'min:0'
            ],
            
            'conteo_materiales.*.cantidad_final' => [
                'required', 
                'integer', 
                'min:0'
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'conteo_materiales' => 'lista de materiales',
            'conteo_materiales.*.tipo_material' => 'tipo de material',
            'conteo_materiales.*.cantidad_inicial' => 'cantidad inicial',
            'conteo_materiales.*.cantidad_agregada' => 'cantidad agregada',
            'conteo_materiales.*.cantidad_final' => 'cantidad final',
        ];
    }

    /**
     * Mensajes personalizados de error (Opcional, pero muy útil para el frontend).
     */
    public function messages(): array
    {
        return [
            'conteo_materiales.required' => 'Debe registrar al menos un material.',
            'conteo_materiales.*.tipo_material.required' => 'El tipo de material es obligatorio.',
            'conteo_materiales.*.cantidad_inicial.integer' => 'La cantidad inicial debe ser un número.',
            'conteo_materiales.*.cantidad_final.min' => 'La cantidad final no puede ser negativa.',
        ];
    }
}
