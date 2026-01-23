<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotaPostoperatoriaRequest extends FormRequest
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
            'ta'    => ['required', 'string', 'max:20'], 
            'fc'    => ['required', 'integer', 'between:0,300'],
            'fr'    => ['required', 'integer', 'between:0,100'],
            'temp'  => ['required', 'numeric', 'between:30,45'],
            'peso'  => ['required', 'numeric', 'between:0.1,600'],
            'talla' => ['required', 'integer', 'between:20,300'],

            'resumen_del_interrogatorio'       => ['required', 'string', 'min:5', 'max:10000'],
            'exploracion_fisica'               => ['required', 'string', 'min:5', 'max:10000'],
            'resultado_estudios'               => ['required', 'string', 'min:5', 'max:10000'],
            'tratamiento'                      => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_o_problemas_clinicos' => ['required', 'string', 'min:5', 'max:10000'],
            'plan_de_estudio'                  => ['required', 'string', 'min:5', 'max:10000'],
            'pronostico'                       => ['required', 'string', 'min:5', 'max:10000'],

            'hora_inicio_operacion'  => ['required', 'date'],
            'hora_termino_operacion' => ['required', 'date', 'after_or_equal:hora_inicio_operacion'],

            'diagnostico_preoperatorio'      => ['required', 'string', 'min:5', 'max:10000'],
            'operacion_planeada'             => ['required', 'string', 'min:5', 'max:10000'],
            'operacion_realizada'            => ['required', 'string', 'min:5', 'max:10000'],
            'diagnostico_postoperatorio'     => ['required', 'string', 'min:5', 'max:10000'],
            'descripcion_tecnica_quirurgica' => ['required', 'string', 'min:5', 'max:10000'],

            'hallazgos_transoperatorios' => ['required', 'string', 'min:5', 'max:10000'],
            'reporte_conteo'             => ['required', 'string', 'min:5', 'max:10000'],
            'incidentes_accidentes'      => ['required', 'string', 'min:5', 'max:10000'],
            'cuantificacion_sangrado'    => ['required', 'string', 'min:1', 'max:10000'],
            'hallazgos_importancia'      => ['required', 'string', 'min:5', 'max:10000'],

            'estado_postquirurgico'    => ['required', 'string', 'min:5', 'max:10000'],
            'manejo_dieta'             => ['nullable', 'string', 'max:10000'],
            'manejo_soluciones'        => ['nullable', 'string', 'max:10000'],
            'manejo_medicamentos'      => ['nullable', 'string', 'max:10000'],
            'manejo_medidas_generales' => ['nullable', 'string', 'max:10000'],
            'manejo_laboratorios'      => ['nullable', 'string', 'max:10000'],

            'ayudantes_agregados'           => ['nullable', 'array'],
            'ayudantes_agregados.*.ayudante_id' => ['required', 'numeric', 'exists:users,id'],
            'ayudantes_agregados.*.cargo'       => ['required', 'string', 'max:255'],

            'transfusiones_agregadas'                   => ['nullable', 'array'],
            'transfusiones_agregadas.*.tipo_transfusion' => ['required', 'string', 'max:255'],
            'transfusiones_agregadas.*.cantidad'         => ['required', 'string', 'max:255'],

            'estudio_solicitado'       => ['nullable', 'string', 'max:255'],
            'biopsia_pieza_quirurgica' => ['nullable', 'string', 'max:255'],
            'revision_laminillas'      => ['nullable', 'string', 'max:255'],
            'estudios_especiales'      => ['nullable', 'string', 'max:255'],
            'pcr'                      => ['nullable', 'string', 'max:255'],
            'pieza_remitida'           => ['nullable', 'string', 'max:255'],
            'datos_clinicos'           => ['nullable', 'string', 'max:10000'], 
            'empresa_enviar'           => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            // Signos Vitales
            'ta'    => 'tensión arterial',
            'fc'    => 'frecuencia cardíaca',
            'fr'    => 'frecuencia respiratoria',
            'temp'  => 'temperatura',
            'peso'  => 'peso',
            'talla' => 'talla',

            // Tiempos
            'hora_inicio_operacion'  => 'hora de inicio',
            'hora_termino_operacion' => 'hora de término',

            // Detalles Operación
            'diagnostico_preoperatorio'      => 'diagnóstico preoperatorio',
            'operacion_planeada'             => 'operación planeada',
            'operacion_realizada'            => 'operación realizada',
            'diagnostico_postoperatorio'     => 'diagnóstico postoperatorio',
            'descripcion_tecnica_quirurgica' => 'descripción de técnica quirúrgica',
            'cuantificacion_sangrado'        => 'cuantificación de sangrado',

            // Arrays
            'ayudantes_agregados.*.cargo'               => 'cargo del ayudante',
            'transfusiones_agregadas.*.tipo_transfusion' => 'tipo de transfusión',
            'transfusiones_agregadas.*.cantidad'         => 'cantidad de transfusión',
        ];
    }

    public function messages(): array
    {
        return [
            // Genéricos
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser texto.',
            'numeric'  => 'El campo :attribute debe ser un número.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'date'     => 'El campo :attribute debe ser una fecha válida.',
            'array'    => 'El campo :attribute debe ser una lista válida.',

            // Rangos y Límites
            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'min'     => 'El campo :attribute es muy corto (mínimo :min caracteres).',
            'max'     => 'El campo :attribute es demasiado extenso (máximo :max caracteres).',

            // Lógica de fechas
            'hora_termino_operacion.after_or_equal' => 'La hora de término no puede ser anterior a la hora de inicio.',

            // Arrays (Ayudantes y Transfusiones)
            'ayudantes_agregados.*.ayudante_id.exists' => 'El ayudante seleccionado no es válido.',
            'ayudantes_agregados.*.cargo.required'     => 'Debe especificar el cargo del ayudante.',
            
            'transfusiones_agregadas.*.tipo_transfusion.required' => 'Especifique el tipo de transfusión.',
            'transfusiones_agregadas.*.cantidad.required'         => 'Especifique la cantidad de la transfusión.',
        ];
    }
}
