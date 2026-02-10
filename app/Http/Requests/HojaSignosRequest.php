<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class HojaSignosRequest extends FormRequest
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
            'tension_arterial_sistolica'  => ['nullable', 'integer', 'min:0', 'max:300', 'required_with:tension_arterial_diastolica'],
            'tension_arterial_diastolica' => ['nullable', 'integer', 'min:0', 'max:200', 'required_with:tension_arterial_sistolica'],
            'frecuencia_cardiaca'         => ['nullable', 'integer', 'min:0', 'max:300'],
            'frecuencia_respiratoria'     => ['nullable', 'integer', 'min:0', 'max:150'],
            'saturacion_oxigeno'          => ['nullable', 'integer', 'min:0', 'max:100'],
            'glucemia_capilar'            => ['nullable', 'integer', 'min:0', 'max:1000'],
            'temperatura'                 => ['nullable', 'numeric', 'min:0', 'max:50'],
            'talla'                       => ['nullable', 'numeric', 'min:0', 'max:300'],
            'peso'                        => ['nullable', 'numeric', 'min:0', 'max:600'],
            'estado_conciencia'           => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'tension_arterial_sistolica'  => 'T.A. sistólica',
            'tension_arterial_diastolica' => 'T.A. diastólica',
            'frecuencia_cardiaca'         => 'frecuencia cardíaca',
            'frecuencia_respiratoria'     => 'frecuencia respiratoria',
            'saturacion_oxigeno'          => 'saturación de oxígeno',
            'glucemia_capilar'            => 'glucemia capilar',
            'temperatura'                 => 'temperatura',
            'talla'                       => 'talla',
            'peso'                        => 'peso',
            'estado_conciencia'           => 'estado de conciencia',
        ];
    }

    public function messages(): array
    {
        return [
            'integer'       => 'El campo :attribute debe ser un número entero.',
            'numeric'       => 'El campo :attribute debe ser un valor numérico.',
            'min'           => 'El campo :attribute no puede ser un valor negativo.',
            'max'           => 'El campo :attribute no debe exceder el valor máximo permitido (:max).',
            'required_with' => 'Debes ingresar ambas cifras de la tensión arterial (sistólica y diastólica).',
            'string'        => 'El campo :attribute debe ser una cadena de texto.',
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
                    'Debe completar al menos un campo para poder guardar el registro de signos vitales.'
                );
            }
        });
    }
}
