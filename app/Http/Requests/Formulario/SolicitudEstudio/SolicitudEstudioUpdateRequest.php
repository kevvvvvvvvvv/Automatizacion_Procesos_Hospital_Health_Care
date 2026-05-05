<?php

namespace App\Http\Requests\Formulario\SolicitudEstudio;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SolicitudEstudioUpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grupos' => 'required|array',
            'grupos.*.fecha_hora_grupo' => 'nullable|date',
            'grupos.*.problema_clinico' => 'nullable|string|max:500',
            'grupos.*.incidentes_accidentes' => 'nullable|string|max:500',
            'grupos.*.archivos' => 'nullable|array',
            'grupos.*.archivos.*' => 'file|mimes:pdf,jpg,jpeg,png,xlsx,xls|max:10240',
            
            'grupos.*.items' => 'required|array',
            'grupos.*.items.*.id' => 'required|exists:solicitud_items,id',
            'grupos.*.items.*.cancelado' => 'boolean',
            'grupos.*.items.*.catalogo_estudio_id' => 'required|exists:catalogo_estudios,id',
        ];
    }
}
