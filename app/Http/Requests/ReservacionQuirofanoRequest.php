<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservacionQuirofanoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        dd($this->all);
        return [
            'estancia_id'          => 'nullable|exists:estancias,id',
            'paciente'             => 'nullable|string|max:255',
            'tratante'             => 'required|string|max:255',
            'procedimiento'        => 'required|string|max:500',
            'tiempo_estimado'      => 'required|string|max:100',
            'medico_operacion'     => 'required|string|max:255',
            'fecha'                => 'required|date|after_or_equal:today',
            'horarios'             => 'required|array|min:1',
            'instrumentista'       => 'nullable|string',
            'anestesiologo'        => 'nullable|string',
            'insumos_medicamentos' => 'nullable|string',
            'esterilizar_detalle'  => 'nullable|string',
            'rayosx_detalle'       => 'nullable|string',
            'patologico_detalle'   => 'nullable|string',
            'comentarios'          => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.after_or_equal' => 'La fecha no puede ser anterior a hoy.',
            'horarios.required'    => 'Debe seleccionar al menos un horario.',
            'tratante.required'    => 'El médico tratante es obligatorio.',
        ];
    }
}