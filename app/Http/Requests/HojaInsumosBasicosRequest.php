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
        ];
    }

    public function messages(): array
    {
        return [
            'cantidad.min' => 'La cantidad no puede ser menor a 1'
        ];
    }
}
