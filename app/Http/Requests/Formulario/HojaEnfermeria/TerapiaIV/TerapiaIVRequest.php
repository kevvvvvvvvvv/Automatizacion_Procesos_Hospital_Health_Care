<?php

namespace App\Http\Requests\Formulario\HojaEnfermeria\TerapiaIV;

use Illuminate\Foundation\Http\FormRequest;

class TerapiaIVRequest extends FormRequest
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
            'terapias_agregadas' => 'required|array|min:1',
            
            //Solución
            'terapias_agregadas.*.es_manual' => 'required|boolean',
            'terapias_agregadas.*.solucion_id' => 'required_if:terapias_agregadas.*.es_manual,false|nullable|exists:producto_servicios,id',
            'terapias_agregadas.*.nombre_solucion' => 'required|string',
            'terapias_agregadas.*.cantidad' => 'required|numeric|min:0',
            'terapias_agregadas.*.duracion' => 'required|numeric|min:0',
            'terapias_agregadas.*.flujo' => 'required|numeric|min:0',

            //Medicamento
            'terapias_agregadas.*.medicamentos' => 'present|array', 
            'terapias_agregadas.*.medicamentos.*.es_manual' => 'required|boolean',  
            'terapias_agregadas.*.medicamentos.*.id' => 'required_if:terapias_agregadas.*.medicamentos.*.es_manual,false|nullable|exists:producto_servicios,id', 
            'terapias_agregadas.*.medicamentos.*.nombre' => 'required|string', 
            'terapias_agregadas.*.medicamentos.*.dosis' => 'required|numeric|min:0', 
            'terapias_agregadas.*.medicamentos.*.unidad' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'terapias_agregadas' => 'lista de terapias',
            
            // Solución
            'terapias_agregadas.*.solucion_id' => 'solución del catálogo',
            'terapias_agregadas.*.nombre_solucion' => 'nombre de la solución',
            'terapias_agregadas.*.cantidad' => 'cantidad de la solución (ml)',
            'terapias_agregadas.*.duracion' => 'duración de la terapia (hrs)',
            'terapias_agregadas.*.flujo' => 'flujo (ml/hr)',
            
            // Medicamentos
            'terapias_agregadas.*.medicamentos' => 'lista de medicamentos',
            'terapias_agregadas.*.medicamentos.*.id' => 'medicamento del catálogo',
            'terapias_agregadas.*.medicamentos.*.nombre' => 'nombre del medicamento',
            'terapias_agregadas.*.medicamentos.*.dosis' => 'dosis del medicamento',
            'terapias_agregadas.*.medicamentos.*.unidad' => 'unidad de medida',
        ];
    }

}
