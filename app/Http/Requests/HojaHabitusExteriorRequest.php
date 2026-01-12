<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaHabitusExteriorRequest extends FormRequest
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
            'sexo' => 'required',
            'condicion_llegada' => 'required',
            'facies' => 'required',
            'constitucion' => 'required',
            'postura' => 'required',
            'piel' => 'required',
            'estado_conciencia' => 'required',
            'marcha' => 'required',
            'movimientos' => 'required',
            'higiene' => 'required',
            'edad_aparente' => 'required',
            'orientacion' => 'required',
            'lenguaje' => 'required',
            'olores_ruidos' => 'required'
        ];
    }

    public function messages(): array 
    {
        return [
            'sexo.required' => 'El sexo es obligatorio.',
            'condicion_llegada.required' => 'La condición de llegada del paciente es obligatoria.',
            'facies.required' => 'Debe indicar el tipo de facies.',
            'constitucion.required' => 'La constitución física es obligatoria.',
            'postura.required' => 'Debe especificar la postura del paciente.',
            'piel.required' => 'El estado de la piel es obligatorio.',
            'estado_conciencia.required' => 'El estado de conciencia es obligatorio.',
            'marcha.required' => 'Debe describir la marcha o locomoción.',
            'movimientos.required' => 'Debe indicar si existen movimientos anormales.',
            'higiene.required' => 'El estado de higiene es obligatorio.',
            'edad_aparente.required' => 'La edad aparente es obligatoria.',
            'orientacion.required' => 'La orientacion es obligatoria',
            'lenguaje.required' => 'El lenguaje es obligatorio.',
            'olores_ruidos.required' => 'Los olores y ruidos anormales son obligatorios.',
        ];
    }
}
