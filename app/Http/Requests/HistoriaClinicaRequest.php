<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoriaClinicaRequest extends FormRequest
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
            'padecimiento_actual'     => ['required', 'string', 'min:5', 'max:10000'],
            'resultados_previos'      => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico'             => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'              => ['required', 'string', 'min:5', 'max:10000'],
            'indicacion_terapeutica'  => ['required', 'string', 'min:5', 'max:10000'],

            'tension_arterial'        => ['required', 'string', 'min:5', 'max:20'], 
            'frecuencia_cardiaca'     => ['required', 'integer', 'between:0,300'],
            'frecuencia_respiratoria' => ['required', 'integer', 'between:0,100'],
            'saturacion_oxigeno'      => ['nullable', 'integer', 'between:0,100'], 
            'temperatura'             => ['required', 'numeric', 'between:30,45'], 
            'peso'                    => ['required', 'numeric', 'between:0.1,600'], 
            'talla'                   => ['required', 'integer', 'between:20,300'], 
            'respuestas'              => ['required', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'padecimiento_actual'     => 'padecimiento actual',
            'tension_arterial'        => 'tensión arterial',
            'frecuencia_cardiaca'     => 'frecuencia cardíaca',
            'frecuencia_respiratoria' => 'frecuencia respiratoria',
            'temperatura'             => 'temperatura',
            'peso'                    => 'peso',
            'talla'                   => 'talla',
            'resultados_previos'      => 'resultados previos',
            'diagnostico'             => 'diagnóstico',
            'pronostico'              => 'pronóstico',
            'indicacion_terapeutica'  => 'indicación terapéutica',
            'respuestas'              => 'respuestas',
            'saturacion_oxigeno'      => 'saturación de oxígeno',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'numeric'  => 'El campo :attribute debe ser un valor numérico.',
            'array'    => 'El formato de :attribute no es válido.',
            
            'between'  => 'El campo :attribute debe estar entre :min y :max.',
            'min'      => 'El campo :attribute debe tener al menos :min caracteres.',
            'max'      => 'El campo :attribute no debe exceder los :max caracteres.',
            
            'tension_arterial.min' => 'La tensión arterial parece incompleta (ej. 120/80).',
            'peso.between'         => 'El peso debe ser un valor lógico (entre 0.1kg y 600kg).',
            'talla.between'        => 'La talla debe estar entre 20 cm y 300 cm.',
        ];
    }
}
