<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrasladoRequest extends FormRequest
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
            'unidad_medica_envia' => ['string', 'required', 'max:255'],
            'unidad_medica_recibe' => ['string', 'required', 'max:255'],
            'motivo_translado' => ['string', 'required'],
            'resumen_clinico' => ['string', 'nullable'],
            'ta' => ['string', 'nullable', 'max:255'],
            'fc' => ['numeric', 'nullable'],
            'fr' => ['numeric', 'nullable'],
            'sat' => ['numeric', 'nullable'],
            'temp' => ['numeric', 'nullable'],
            'dxtx' => ['string', 'nullable', 'max:255'],
            'tratamiento_terapeutico_administrada' => ['string', 'nullable'],
        ];
    }
    public function messages()
    {
        return [
            'unidad_medica_envia.required' => 'La unidad médica que envía es obligatoria.',
            'unidad_medica_envia.string' => 'La unidad médica que envía debe ser una cadena de texto.',
            'unidad_medica_envia.max' => 'La unidad médica que envía no debe exceder los 255 caracteres.',

            'unidad_medica_recibe.required' => 'La unidad médica que recibe es obligatoria.',
            'unidad_medica_recibe.string' => 'La unidad médica que recibe debe ser una cadena de texto.',
            'unidad_medica_recibe.max' => 'La unidad médica que recibe no debe exceder los 255 caracteres.',

            'motivo_translado.required' => 'El motivo del traslado es obligatorio.',
            'motivo_translado.string' => 'El motivo del traslado debe ser una cadena de texto.',

            'Resumen_clinico.string' => 'El resumen clínico debe ser una cadena de texto.',

            'ta.string' => 'La tensión arterial debe ser una cadena de texto.',
            'ta.max' => 'La tensión arterial no debe exceder los 255 caracteres.',

            'fc.numeric' => 'La frecuencia cardíaca debe ser un número.',

            'fr.numeric' => 'La frecuencia respiratoria debe ser un número.',

            'sat.numeric' => 'La saturación debe ser un número.',

            'temp.numeric' => 'La temperatura debe ser un número.',

            'dxtx.string' => 'El diagnóstico debe ser una cadena de texto.',
            'dxtx.max' => 'El diagnóstico no debe exceder los 255 caracteres.',

            'tratamiento_terapeutico_administrada.string' => 'El tratamiento terapéutico administrado debe ser una cadena de texto.',
        ];
    }
}