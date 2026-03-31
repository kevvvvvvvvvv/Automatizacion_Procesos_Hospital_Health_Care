<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $doctore = $this->route('doctore');

        return [
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'nullable|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'curp' => [
                'nullable',
                'string',
                'max:18',
                Rule::unique('users', 'curp')->ignore($doctore), 
            ],
            'sexo' => 'required|in:Masculino,Femenino',
            'fecha_nacimiento' => 'nullable|date',
            'cargo_id' => 'required', 
            'colaborador_responsable_id' => 'nullable|exists:users,id', 
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($doctore),
            ],
            'password' => $this->isMethod('post') 
                    ? 'required|min:8|confirmed' 
                    : 'nullable|min:8|confirmed', 
                    
            'telefono' => 'nullable',

            'professional_qualifications' => 'nullable|array',
            'professional_qualifications.*.titulo' => 'nullable|string|max:100',
            'professional_qualifications.*.cedula_profesional' => $this->isMethod('post') 
                    ? 'nullable|string|max:50|unique:credencial_empleados,cedula_profesional'
                    : 'nullable|string|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto válido.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            
            'apellido_paterno.string' => 'El apellido paterno debe ser texto válido.',
            'apellido_paterno.max' => 'El apellido paterno no puede exceder los 100 caracteres.',
            
            'apellido_materno.string' => 'El apellido materno debe ser texto válido.',
            'apellido_materno.max' => 'El apellido materno no puede exceder los 100 caracteres.',
        
            'curp.string' => 'La CURP debe ser texto válido.',
            'curp.max' => 'La CURP no puede tener más de 18 caracteres.',
            'curp.unique' => 'Esta CURP ya está registrada en el sistema a nombre de otro usuario.',

            'sexo.required' => 'Debe seleccionar el sexo del usuario.',
            'sexo.in' => 'El sexo seleccionado no es válido (debe ser Masculino o Femenino).',
            
            'fecha_nacimiento.date' => 'La fecha de nacimiento no tiene un formato válido.',
            
            'cargo_id.required' => 'Es obligatorio asignar un cargo o rol al usuario.',
            
            'colaborador_responsable_id.exists' => 'El colaborador responsable seleccionado no existe en el sistema.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo electrónico válido (ejemplo@hospital.com).',
            'email.unique' => 'Este correo electrónico ya está en uso por otro usuario.',

            'password.required' => 'La contraseña es obligatoria para crear un nuevo registro.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres por seguridad.',
            'password.confirmed' => 'Las contraseñas no coinciden. Por favor, verifíquelas.',

            'professional_qualifications.array' => 'El formato de las credenciales profesionales no es válido.',
            
            'professional_qualifications.*.titulo.string' => 'El título ingresado debe ser texto válido.',
            'professional_qualifications.*.titulo.max' => 'El título no puede exceder los 100 caracteres.',
            
            'professional_qualifications.*.cedula_profesional.string' => 'La cédula profesional debe ser texto válido.',
            'professional_qualifications.*.cedula_profesional.max' => 'La cédula profesional no puede exceder los 50 caracteres.',
            'professional_qualifications.*.cedula_profesional.unique' => 'Una de las cédulas profesionales ingresadas ya está registrada en el sistema.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre(s)',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'curp' => 'CURP',
            'sexo' => 'sexo',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'cargo_id' => 'cargo o rol',
            'colaborador_responsable_id' => 'colaborador responsable',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'telefono' => 'teléfono',
            'professional_qualifications' => 'credenciales profesionales',
            'professional_qualifications.*.titulo' => 'título profesional',
            'professional_qualifications.*.cedula_profesional' => 'cédula profesional',
        ];
    }
}
