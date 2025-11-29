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
            //Generalidades
            'ta'    => 'required|string|max:20',    // Tensión Arterial
            'fc'    => 'required|integer|min:0',    // Frecuencia Cardíaca
            'fr'    => 'required|integer|min:0',    // Frecuencia Respiratoria
            'temp'  => 'required|numeric|between:30,45', // Temperatura
            'peso'  => 'required|numeric|min:0',    // Peso
            'talla' => 'required|integer|min:0',    // Talla 
            'resumen_del_interrogatorio' => 'required|string',
            'exploracion_fisica'         => 'required|string',
            'resultado_estudios'               => 'nullable|string',
            'tratamiento'                      => 'nullable|string',
            'diagnostico_o_problemas_clinicos' => 'required|string',
            'plan_de_estudio'                  => 'required|string',
            'pronostico'                       => 'required|string',

            // Tiempos
            'hora_inicio_operacion' => 'required|date',
            'hora_termino_operacion' => 'required|date|after_or_equal:hora_inicio_operacion',

            // Diagnósticos y Operación (Campos requeridos)
            'diagnostico_preoperatorio' => 'required|string',
            'operacion_planeada' => 'required|string',
            'operacion_realizada' => 'required|string',
            'diagnostico_postoperatorio' => 'required|string',
            
            // Descripción (Requerida)
            'descripcion_tecnica_quirurgica' => 'required|string',
            
            // Hallazgos y Reportes (Opcionales)
            'hallazgos_transoperatorios' => 'required|string',
            'reporte_conteo' => 'required|string',
            'incidentes_accidentes' => 'required|string',
            'cuantificacion_sangrado' => 'required|string',

            'manejo_dieta' => 'nullable|string',
            'manejo_soluciones' => 'nullable|string',
            'manejo_medicamentos'=> 'nullable|string',
            'manejo_medidas_generales' => 'nullable|string',
            'manejo_laboratorios' => 'nullable|string',
            
            // Post-quirúrgico (Requeridos)
            'estado_postquirurgico' => 'required|string',
            'pronostico' => 'required|string',
            'hallazgos_importancia' => 'required|string',

            'ayudantes_agregados' => 'nullable|array',
            'ayudantes_agregados.*.ayudante_id' => 'required|numeric|exists:users,id',
            'ayudantes_agregados.*.cargo' => 'required|string|max:255',

            // Reglas para Transfusiones
            'transfusiones_agregadas' => 'nullable|array',
            'transfusiones_agregadas.*.tipo_transfusion' => 'required|string|max:255',
            'transfusiones_agregadas.*.cantidad' => 'required|string|max:255',

            //Pieza patologica
            'estudio_solicitado'       => 'nullable|string|max:255',
            'biopsia_pieza_quirurgica' => 'nullable|string|max:255',
            'revision_laminillas'      => 'nullable|string|max:255',
            'estudios_especiales'      => 'nullable|string|max:255',
            'pcr'                      => 'nullable|string|max:255',
            'pieza_remitida'           => 'nullable|string|max:255',
            'datos_clinicos'           => 'nullable|string',
            'empresa_enviar'           => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            // Mensajes para 'required'
            'required' => 'El campo :attribute es obligatorio.',
            
            // Mensajes para 'date'
            'date' => 'El campo :attribute debe ser una fecha y hora válida.',

            // Mensajes específicos
            'hora_termino_operacion.after_or_equal' => 'La hora de término no puede ser anterior a la hora de inicio.',
            'diagnostico_preoperatirio.required' => 'El diagnóstico preoperatorio es obligatorio.',
            'operacion_realizada.required' => 'El campo operación realizada es obligatorio.',
            'estado_postquirurgico.required' => 'El estado postquirúrgico es obligatorio.',
            'manejo_tratamienot.required' => 'El plan de manejo y tratamiento es obligatorio.',
        ];
    }
}
