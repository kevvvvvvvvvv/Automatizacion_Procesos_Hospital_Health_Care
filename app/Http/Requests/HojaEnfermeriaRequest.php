<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaEnfermeriaRequest extends FormRequest
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
            'observaciones' => 'nullable|string',
            'estado' => 'string|nullable|in:Abierto,Cerrado',
            'habitus_exterior' => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'observaciones.string' => 'Las observaciones tienen que ser una cadena de texto',
            'estado.in' => 'El estado solo puede ser "Abierto" o "Cerrado".'
        ];
    }
}
