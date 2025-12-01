<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HojaEnfermeriaQuirofanoRequest extends FormRequest
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
            'hora_inicio_cirugia' => 'nullable',
            'hora_inicio_anestesia' => 'nullable',
            'hora_inicio_paciente' => 'nullable',
            'hora_fin_cirugia' => 'nullable',
            'hora_fin_anestesia' => 'nullable',
            'hora_fin_paciente' => 'nullable'
        ];
    }
}
