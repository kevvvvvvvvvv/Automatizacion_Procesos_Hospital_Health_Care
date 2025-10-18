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
            'padecimiento_actual'       => 'required|string',
            'tension_arterial'          => 'required|string|max:20',
            'frecuencia_cardiaca'       => 'required|integer',
            'frecuencia_respiratoria'   => 'required|integer',
            'temperatura'               => 'required|numeric',
            'peso'                      => 'required|numeric',
            'talla'                     => 'required|integer',
            'resultados_previos'        => 'required|string',
            'diagnostico'               => 'required|string',
            'pronostico'                => 'required|string',
            'indicacion_terapeutica'    => 'required|string',
            'respuestas'                => 'required|array',
        ];
    }

    public function messages(): array
    {
        return [
            
            'padecimiento_actual.required' => 'El campo de padecimiento actual es obligatorio.',
            'tension_arterial.required' => 'El campo de tensión arterial es obligatorio.',
            'frecuencia_cardiaca.required' => 'El campo de frecuencia cardíaca es obligatorio.',
            'frecuencia_respiratoria.required' => 'El campo de frecuencia respiratoria es obligatorio.',
            'temperatura.required' => 'El campo de temperatura es obligatorio.',
            'peso.required' => 'El campo de peso es obligatorio.',
            'talla.required' => 'El campo de talla es obligatorio.',
            'diagnostico.required' => 'El campo de diagnóstico es obligatorio.',
            'pronostico.required' => 'El campo de pronóstico es obligatorio.',
            'indicacion_terapeutica.required' => 'El campo de indicación terapéutica es obligatorio.',
            'respuestas.required' => 'Es necesario proporcionar las respuestas del formulario.',
            'resultados_previos.required' => 'El campo de resultados previos es obligatorio',

            'frecuencia_cardiaca.integer' => 'La frecuencia cardíaca debe ser un número entero.',
            'frecuencia_respiratoria.integer' => 'La frecuencia respiratoria debe ser un número entero.',
            'temperatura.numeric' => 'La temperatura debe ser un valor numérico.',
            'peso.numeric' => 'El peso debe ser un valor numérico.',
            'talla.integer' => 'La talla debe ser un número entero.',
            'respuestas.array' => 'El formato de las respuestas no es válido.',

            'tension_arterial.max' => 'La tensión arterial no debe exceder los 20 caracteres.',
        ];
    }
}
