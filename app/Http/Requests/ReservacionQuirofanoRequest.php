<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ReservacionQuirofanoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        
        return [ 
            
            'paciente' => ['nullable','string'],

            'tratante' => ['required','string'],
            'procedimiento' => ['required','string'],
            'tiempo_estimado' => ['required','string'],
            'medico_operacion' => ['required','string'],

            'laparoscopia_detalle' => ['nullable','string'],
            'instrumentista' => ['nullable','string'],
            'anestesiologo' => ['nullable','string'],
            'insumos_medicamentos' =>[ 'nullable','string'],
            'esterilizar_detalle' => ['nullable','string'],
            'rayosx_detalle' => ['nullable','string'],
            'patologico_detalle' => ['nullable','string'],

            'comentarios' => ['nullable','string'],
            'horarios' => ['required','array'],
            'fecha' => ['required','date'],
        ];
        dd($this->all());
    }
    public function messages():array
    {
        
        return[
            //
        ];
    }

    
}
