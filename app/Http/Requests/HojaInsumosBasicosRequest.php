<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaInsumosBasicosRequest extends FormRequest
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
            'cantidad' => 'required|integer|min:1', 
            'producto_servicio_id' => 'nullable|integer',
            'nombre_insumo' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre_insumo' => 'nombre del insumo',
            'cantidad' => 'cantidad',
            'producto_servicio_id' => 'insumo del catálogo',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es indispensable para el registro.',
            'min'      => 'La :attribute debe ser de al menos :min.',
            'integer'  => 'Asegúrate de que :attribute sea un número entero.',
        ];
    }
}
