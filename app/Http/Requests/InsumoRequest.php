<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // producto_servicios
            'tipo' => 'required|string|max:100',
            'subtipo' => 'required|string|max:100',
            'nombre_prestacion' => 'required|string|max:200',
            'importe' => 'required|numeric|min:0',
            'importe_compra' => 'nullable|numeric|min:0',

            'cantidad' => 'nullable|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'cantidad_maxima' => 'nullable|integer|min:0',

            'proveedor' => 'nullable|string|max:200',
            'fecha_caducidad' => 'nullable|date',

            // insumo
            'categoria' => 'required|string|max:200',
            'especificacion' => 'required|string|max:200',
            'categoria_unitaria' => 'required|string|max:200',
        ];
    }
}
