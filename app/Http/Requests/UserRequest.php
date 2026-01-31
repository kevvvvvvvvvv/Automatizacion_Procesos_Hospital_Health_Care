<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'curp' => 'required|string|max:18|unique:users,curp', 
            'sexo' => 'required|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required', 
            'colaborador_responsable_id' => 'nullable|exists:users,id', 
            'email' => 'required|email|email',
            'password' => 'required|min:8|confirmed', 
            'telefono' => 'required',

            'professional_qualifications' => 'nullable|array',
            'professional_qualifications.*.titulo' => 'nullable|string|max:100',
            'professional_qualifications.*.cedula' => 'nullable|string|max:50|unique:credencial_empleados,cedula_profesional', 
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'apellido_paterno.max' => 'El apellido paterno no puede tener más de 100 caracteres.',
            
            'apellido_materno.required' => 'El apellido materno es obligatorio.',
            'apellido_materno.max' => 'El apellido materno no puede tener más de 100 caracteres.',
    
            'curp.required' => 'La CURP es oblogatorio',
            'curp.unique' => 'Esta CURP ya se encuentra registrada en el sistema.',
            'curp.max' => 'La CURP no debe exceder los 18 caracteres.',

            'sexo.in' => 'La opción de sexo seleccionada no es válida.',
            'sexo.required' => 'El sexo es oblogatorio',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'El formato de la fecha de nacimiento no es válido.',
            'telefono.required' => 'El teléfono es requerido.',

            // --- Cargo y Responsable ---
            'cargo_id.required' => 'Debes seleccionar un cargo para el usuario.',
            'cargo_id.exists' => 'El cargo seleccionado no existe en la base de datos.',
            
            'colaborador_responsable_id.exists' => 'El colaborador responsable seleccionado no es válido.',

            // --- Cuenta de Usuario ---
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debes ingresar un correo electrónico válido.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',

            // --- Títulos y Cédulas (Arrays) ---
            'professional_qualifications.array' => 'El formato de las cualificaciones es incorrecto.',
            'professional_qualifications.min' => 'Debes registrar por lo menos un título.',

            // El asterisco (*) sirve para validar cada fila de la lista dinámica
            'professional_qualifications.*.titulo.max' => 'El título no puede exceder los 100 caracteres.',
            
            'professional_qualifications.*.cedula.max' => 'La cédula no puede exceder los 50 caracteres.',
            'professional_qualifications.*.cedula.unique' => 'Una de las cédulas ingresadas ya está registrada en el sistema.',
        ];
    }
}
