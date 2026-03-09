<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [

            // ================= PRODUCTO BASE =================
            'tipo' => 'required|string|max:100',
            'subtipo' => 'required|string|in:MEDICAMENTOS,INSUMOS,ESTUDIOS',

            'nombre_prestacion' => 'required|string|max:200',
            'codigo_barras' => 'nullable|string|max:100',

            'importe' => 'required|numeric|min:0',
            'importe_compra' => 'nullable|numeric|min:0',

            'cantidad' => 'nullable|integer|min:0',
            'cantidad_minima' => 'nullable|integer|min:0',
            'cantidad_maxima' => 'nullable|integer|min:0',

            'proveedor' => 'nullable|string|max:150',
            'fecha_caducidad' => 'nullable|date',
        ];

        // ================= MEDICAMENTOS =================
        if ($this->subtipo === 'MEDICAMENTOS') {
            $rules += [

                'excipiente_activo_gramaje' => 'string|max:500',

                // 🔥 SOLO NUMEROS
                'volumen_total' => 'numeric|min:0',

                'nombre_comercial' => 'string|max:200',
                'gramaje' => 'string|max:100',

                // boolean real
                'fraccion' => 'boolean',

                'via_administracion' => 'nullable|array'
            ];
        }
        // ==============Estudios================
        if ($this->subtipo === 'ESTUDIOS') {
            $rules += [
                
                'tipo_estudio' => 'nullable|string|max:150',
                'departamento' => 'nullable|string|max:150',
                'tiempo_entrega' => 'nullable|integer|max:30',
            ];


        }

        // ================= INSUMOS =================
        if ($this->subtipo === 'INSUMOS') {
            $rules += [
                'categoria' => 'string|max:200',
                'especificacion' => 'string|max:500',
                'categoria_unitaria' => 'string|max:200',
            ];
        }

        return $rules;
    }

    // 🧠 MENSAJES PROFESIONALES
    public function messages(): array
    {
        return [

            // generales
            'tipo.required' => 'El tipo es obligatorio.',
            'subtipo.required' => 'El subtipo es obligatorio.',
            'subtipo.in' => 'Subtipo inválido.',

            'nombre_prestacion.required' => 'El nombre es obligatorio.',

            'importe.numeric' => 'El importe debe ser numérico.',
            'importe.required' => 'El importe es obligatorio.',

            'cantidad.integer' => 'La cantidad debe ser número entero.',
            'cantidad_minima.integer' => 'Stock mínimo debe ser número.',
            'cantidad_maxima.integer' => 'Stock máximo debe ser número.',

            // 💊 medicamentos
            'excipiente_activo_gramaje.required' => 'El excipiente es obligatorio.',

            'volumen_total.required' => 'El volumen es obligatorio.',
            'volumen_total.numeric' => 'El volumen total SOLO debe contener números.',


        ];
    }
}
