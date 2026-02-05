<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaMedicamentoRequest extends FormRequest
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
            'medicamentos_agregados' => 'required|array|min:1',
            'medicamentos_agregados.*.id' => 'nullable|exists:producto_servicios,id', 
            'medicamentos_agregados.*.nombre_medicamento' => 'required_without:medicamentos_agregados.*.id|nullable|string|max:255',
            'medicamentos_agregados.*.dosis' => 'required|string|max:255',
            'medicamentos_agregados.*.via_id' => 'nullable|string|max:255',
            'medicamentos_agregados.*.gramaje' => 'required',
            'medicamentos_agregados.*.duracion' => 'required|numeric', 
            'medicamentos_agregados.*.unidad' => 'required',
        ];
    }
}
