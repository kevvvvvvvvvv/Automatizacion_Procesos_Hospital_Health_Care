<?php

namespace App\Http\Requests\Caja\Caja;

use Illuminate\Foundation\Http\FormRequest;

class CerrarTurnoRequest extends FormRequest
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
            'monto_declarado' => 'required|numeric|min:0',
            'monto_enviado_contaduria' => 'required|numeric|min:0',
            'desglose' => 'nullable|array', 
            'desglose.*.denominacion' => 'required_with:desglose|numeric|min:0.1',
            'desglose.*.cantidad' => 'required_with:desglose|integer|min:1',
            'desglose.*.total' => 'required_with:desglose|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'monto_declarado' => 'monto declarado',
            'monto_enviado_contaduria' => 'monto a enviar a contaduría',
            'desglose' => 'desglose de efectivo',
            'desglose.*.denominacion' => 'denominación del billete/moneda',
            'desglose.*.cantidad' => 'cantidad de piezas',
            'desglose.*.total' => 'total de la fila',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'min' => 'El campo :attribute no puede ser menor a :min.',
            'array' => 'El :attribute debe tener un formato de lista válido.',
            'required_with' => 'El campo :attribute es obligatorio si estás enviando un desglose.',
            'integer' => 'El campo :attribute debe ser un número entero (no puedes tener medio billete).',
        ];
    }
}
