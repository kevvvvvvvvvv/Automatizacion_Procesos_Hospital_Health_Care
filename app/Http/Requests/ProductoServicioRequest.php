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
    // Forzamos que el subtipo sea comparado en mayúsculas para evitar errores
    $subtipo = strtoupper($this->input('subtipo'));

    $rules = [
        // ================= PRODUCTO BASE =================
        'tipo' => 'required|string|max:100',
        // 1. CORRECCIÓN: Agregamos SERVICIOS a la lista permitida
        'subtipo' => 'required|string|in:MEDICAMENTOS,INSUMOS,ESTUDIOS,SERVICIOS',

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
    if ($subtipo === 'MEDICAMENTOS') {
        $rules += [
            'excipiente_activo_gramaje' => 'required|string|max:500', // 2. CORRECCIÓN: Agregar required si es obligatorio
            'volumen_total' => 'required|numeric|min:0',
            'nombre_comercial' => 'required|string|max:200',
            'gramaje' => 'required|string|max:100',
            'fraccion' => 'required',
            'via_administracion' => 'nullable|array'
        ];
        
    }
    
    // ============== ESTUDIOS / SERVICIOS ================
    if ($subtipo === 'ESTUDIOS' || $subtipo === 'SERVICIOS') {
        $rules += [
            'tipo_estudio' => 'nullable|string|max:150',
            'departamento' => 'nullable|string|max:150',
            'tiempo_entrega' => 'nullable|integer|max:30',
            'link' => 'nullable|string|max:500',
        ];
    }

    // ================= INSUMOS =================
    if ($subtipo === 'INSUMOS') {
        $rules += [
            'categoria' => 'required|string|max:200',
            'especificacion' => 'nullable|string|max:500',
            'categoria_unitaria' => 'nullable|string|max:200',
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
