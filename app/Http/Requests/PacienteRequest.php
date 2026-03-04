<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
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

     protected function prepareForValidation()
    {
        $camposTexto = [
            'curp',
            'nombre',
            'apellido_paterno',
            'apellido_materno',
            'calle',
            'colonia',
            'municipio',
            'estado',
            'pais',
            'ocupacion',
            'lugar_origen',
            'nombre_padre',
            'nombre_madre',
            'sexo',
            'estado_civil'
        ];

        $datosAjustados = [];
        
        foreach ($camposTexto as $campo) {
            if ($this->has($campo) && $this->$campo !== null) {
                $datosAjustados[$campo] = mb_strtoupper($this->$campo, 'UTF-8');
            }
        }

        $this->merge($datosAjustados);
    }

    public function rules(): array
    {
        $pacienteId = $this->route('paciente')->id ?? $this->route('paciente');

        return [
            'curp' => [
                'required',
                'string',
                'max:18',
                Rule::unique('pacientes', 'curp')->ignore($pacienteId),
            ],
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'sexo' => 'required|string',
            'fecha_nacimiento' => 'required|date',
            'calle' => 'required|string|max:100',
            'numero_exterior' => 'required|string|max:50',
            'numero_interior' => 'nullable|string|max:50',
            'colonia' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'cp' => 'required|string|max:10',
            'telefono' => 'required|string|max:20',
            'estado_civil' => 'required|string',
            'ocupacion' => 'nullable|string|max:100',
            'lugar_origen' => 'nullable|string|max:100',
            'nombre_padre' => 'nullable|string|max:100',
            'nombre_madre' => 'nullable|string|max:100',

            'responsables' => 'nullable|array',
            'responsables.*.nombre_completo' => 'nullable|required_with:responsables|string|max:100',
            'responsables.*.parentesco' => 'nullable|required_with:responsables|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'curp' => 'CURP',
            'nombre' => 'nombre',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'sexo' => 'género',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'calle' => 'calle',
            'numero_exterior' => 'número exterior',
            'numero_interior' => 'número interior',
            'colonia' => 'colonia',
            'municipio' => 'municipio',
            'estado' => 'estado',
            'pais' => 'país',
            'cp' => 'código postal',
            'telefono' => 'teléfono',
            'estado_civil' => 'estado civil',
            'ocupacion' => 'ocupación',
            'lugar_origen' => 'lugar de origen',
            'nombre_padre' => 'nombre del padre',
            'nombre_madre' => 'nombre de la madre',
            'responsables.*.nombre_completo' => 'nombre del responsable',
            'responsables.*.parentesco' => 'parentesco del responsable',
        ];
    }

    public function messages(): array
    {
        return [
            'curp.unique' => 'La :attribute ya se encuentra registrada.',
            'curp.regex' => 'El formato de la :attribute no es válido.',
            'sexo.in' => 'El :attribute seleccionado no es válido.',
            '*.required' => 'El campo :attribute es obligatorio para el registro del paciente.',
        ];
    }

}
