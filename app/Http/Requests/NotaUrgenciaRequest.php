<?php

   namespace App\Http\Requests;

   use Illuminate\Foundation\Http\FormRequest;

   class NotaUrgenciaRequest extends FormRequest
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
        'ta' => ['required', 'string'],
        'fc' => ['nullable', 'integer', 'min:0'],
        'fr' => ['nullable', 'integer', 'min:0'],
        'temp' => ['nullable', 'numeric', 'min:20'],
        'peso' => ['nullable', 'numeric', 'min:0'],
        'talla' => ['nullable', 'numeric', 'min:0'],

        'motivo_atencion' => ['required', 'string'],
        'resumen_interrogatorio' => ['required', 'string'],
        'exploracion_fisica' => ['required', 'string'],
        'estado_mental' => ['required', 'string'],
        'resultados_relevantes' => ['required', 'string'],
        'diagnostico_problemas_clinicos' => ['required', 'string'],
        'tratamiento' => ['required', 'string'],
        'pronostico' => ['required', 'string'],
    ];
}


       public function messages(): array
       {
           return [
               'ta.required' => 'La tensión arterial es obligatoria.',
               'ta.string' => 'La tensión arterial debe ser un texto numérico (ej. 120/80).',
               'fc.integer' => 'La frecuencia cardíaca debe ser un número entero.',
               'fc.min' => 'La frecuencia cardíaca no puede ser un valor negativo.',
               'fr.integer' => 'La frecuencia respiratoria debe ser un número entero.',
               'fr.min' => 'La frecuencia respiratoria no puede ser un valor negativo.',
               'temp.numeric' => 'La temperatura debe ser un valor numérico.',
               'temp.min' => 'La temperatura no puede ser menor a 20.',
               'peso.numeric' => 'El peso debe ser un valor numérico.',
               'peso.min' => 'El peso no puede ser un valor negativo.',
               'talla.numeric' => 'La talla debe ser un valor numérico.',
               'talla.min' => 'La talla no puede ser un valor negativo.',
               'motivo_atencion.required' => 'El motivo de atención es obligatorio.',
               'motivo_atencion.string' => 'El motivo de atención debe ser una cadena de texto.',
               'resumen_interrogatorio.required' => 'El resumen del interrogatorio es obligatorio.',
               'resumen_interrogatorio.string' => 'El resumen del interrogatorio debe ser una cadena de texto.',
               'exploracion_fisica.required' => 'La exploración física es obligatoria.',
               'exploracion_fisica.string' => 'La exploración física debe ser una cadena de texto.',
               'estado_mental.required' => 'El estado mental es obligatorio.',
               'estado_mental.string' => 'El estado mental debe ser una cadena de texto.',
               'resultados_relevantes.required' => 'Los resultados relevantes son obligatorios.',
               'resultados_relevantes.string' => 'Los resultados relevantes deben ser una cadena de texto.',
               'diagnostico_problemas_clinicos.required' => 'El diagnóstico de problemas es obligatorio.',  // Corregido: quitada la 'w'
               'diagnostico_problemas_clinicos.string' => 'El diagnóstico de problemas debe ser una cadena de texto.',
               'tratamiento.required' => 'El tratamiento es obligatorio.',
               'tratamiento.string' => 'El tratamiento debe ser una cadena de texto.',
               'pronostico.required' => 'El pronóstico es obligatorio.',
               'pronostico.string' => 'El pronóstico debe ser una cadena de texto.'
           ];
       }
   }
   