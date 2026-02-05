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
        $detonantesPatologia = 'biopsia_pieza_quirurgica,revision_laminillas,estudios_especiales,pcr,datos_clinicos,empresa_enviar';

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
            'cuantificacion_sangrado'    => ['required', 'string', 'max:10000'], 
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

            'estudio_solicitado' => [
                'nullable',
                'required_with:pieza_remitida,' . $detonantesPatologia, 
                'string',
                'max:255'
            ],
            'pieza_remitida' => [
                'nullable',
                'required_with:estudio_solicitado,' . $detonantesPatologia,
                'string',
                'max:255'
            ],
            'biopsia_pieza_quirurgica' => ['nullable', 'string', 'max:255'],
            'revision_laminillas'      => ['nullable', 'string', 'max:255'],
            'estudios_especiales'      => ['nullable', 'string', 'max:255'],
            'pcr'                      => ['nullable', 'string', 'max:255'],
            'datos_clinicos'           => ['nullable', 'string', 'max:10000'],
            'empresa_enviar'           => ['nullable', 'string', 'max:255'],
            'contenedores_enviados'    => ['required', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'ta'    => 'tensión arterial',
            'fc'    => 'frecuencia cardíaca',
            'fr'    => 'frecuencia respiratoria',
            'temp'  => 'temperatura',
            'peso'  => 'peso',
            'talla' => 'talla',

            'hora_inicio_operacion'  => 'hora de inicio',
            'hora_termino_operacion' => 'hora de término',

            'diagnostico_preoperatorio'      => 'diagnóstico preoperatorio',
            'operacion_planeada'             => 'operación planeada',
            'operacion_realizada'            => 'operación realizada',
            'diagnostico_postoperatorio'     => 'diagnóstico postoperatorio',
            'descripcion_tecnica_quirurgica' => 'descripción de técnica quirúrgica',
            'hallazgos_transoperatorios'     => 'hallazgos transoperatorios',
            'cuantificacion_sangrado'        => 'cuantificación de sangrado',
            'hallazgos_importancia'          => 'hallazgos de importancia',

            'ayudantes_agregados.*.cargo'                => 'cargo del ayudante',
            'transfusiones_agregadas.*.tipo_transfusion' => 'tipo de transfusión',
            'transfusiones_agregadas.*.cantidad'         => 'cantidad de transfusión',

            'estudio_solicitado' => 'estudio de patología solicitado',
            'pieza_remitida'     => 'pieza remitida',
            'contenedores_enviados'    => 'contenedores enviados',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string'   => 'El campo :attribute debe ser texto.',
            'numeric'  => 'El campo :attribute debe ser numérico.',
            'integer'  => 'El campo :attribute debe ser un número entero.',
            'date'     => 'El campo :attribute debe ser una fecha válida.',
            'exists'   => 'El valor seleccionado en :attribute no es válido.',

            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'min'     => 'El campo :attribute debe ser más detallado (mínimo :min caracteres).',
            'max'     => 'El campo :attribute es demasiado extenso (máximo :max caracteres).',

            'hora_termino_operacion.after_or_equal' => 'La hora de término no puede ser anterior a la hora de inicio.',

            'ayudantes_agregados.*.ayudante_id.required' => 'Debe seleccionar un ayudante.',
            'ayudantes_agregados.*.cargo.required'       => 'Debe especificar el cargo del ayudante.',

            'transfusiones_agregadas.*.tipo_transfusion.required' => 'Especifique el tipo de sangre/transfusión.',
            'transfusiones_agregadas.*.cantidad.required'         => 'Especifique la cantidad transfundida.',

            'estudio_solicitado.required_with' => 'Si ha indicado una pieza remitida, debe especificar qué estudio solicita.',
            'pieza_remitida.required_with' => 'Si ha solicitado un estudio de patología, es obligatorio especificar la pieza remitida.',
        ];
    }
}
