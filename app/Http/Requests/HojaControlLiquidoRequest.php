<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class HojaControlLiquidoRequest extends FormRequest
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
            'uresis'       => ['required_with:uresis_descripcion', 'nullable', 'integer', 'min:0'],
            'evacuaciones' => ['required_with:evacuaciones_descripcion', 'nullable', 'integer', 'min:0'],
            'emesis'       => ['required_with:emesis_descripcion', 'nullable', 'integer', 'min:0'],
            'drenes'       => ['required_with:drenes_descripcion', 'nullable', 'integer', 'min:0'],

            'uresis_descripcion'       => ['nullable', 'string', 'max:255'],
            'evacuaciones_descripcion' => ['nullable', 'string', 'max:255'],
            'emesis_descripcion'       => ['nullable', 'string', 'max:255'],
            'drenes_descripcion'       => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'uresis'                   => 'cantidad de uresis',
            'evacuaciones'             => 'cantidad de evacuaciones',
            'emesis'                   => 'cantidad de emesis',
            'drenes'                   => 'cantidad de drenes',
            'uresis_descripcion'       => 'descripción de uresis',
            'evacuaciones_descripcion' => 'descripción de evacuaciones',
            'emesis_descripcion'       => 'descripción de emesis',
            'drenes_descripcion'       => 'descripción de drenes',
        ];
    }

    public function messages(): array
    {
        return [
            'required_with' => 'El campo :attribute es obligatorio cuando se ha ingresado una descripción.',
            'integer' => 'El campo :attribute debe ser un número entero.',
            'min'     => 'El campo :attribute no puede ser un valor negativo.',
            'string'  => 'El campo :attribute debe ser una cadena de texto.',
            'max'     => 'El campo :attribute no debe exceder los :max caracteres.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $campos = array_keys($this->rules());
            $valores = $this->only($campos);
            if (empty(array_filter($valores, fn($value) => $value !== null && $value !== ''))) {
                $validator->errors()->add(
                    'registro_vacio', 
                    'Debe completar al menos un campo para poder guardar el registro de control de liquidos.'
                );
            }
        });
    }
}
