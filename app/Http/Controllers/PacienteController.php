<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Inertia\Inertia;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return Inertia::render('pacientes/index', ['pacientes' => $pacientes]);
    }

    public function create()
    {
        // Retorna la vista React con el formulario para crear paciente
        return Inertia::render('pacientes/create');
    }

    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'curp' => 'required|string|max:18|unique:pacientes,curp', // Agregué unique para evitar duplicados
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'sexo' => 'required|string|in:Masculino,Femenino', // Validación para valores permitidos
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
            'estado_civil' => 'required|string|in:Soltero(a),Casado(a),Divorciado(a),Viudo(a),Union libre', // Validación para valores permitidos
            'ocupacion' => 'required|string|max:100',
            'lugar_origen' => 'required|string|max:100',
            'nombre_padre' => 'nullable|string|max:100',
            'nombre_madre' => 'nullable|string|max:100',
        ]);

        // Crear paciente
        Paciente::create($validated);

        // Redirigir o responder
        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
    }

    public function show(Paciente $paciente)
    {
        // Cargar relaciones si es necesario (ej. estancias)
        $paciente->load('estancias'); // Usa load() en lugar de with() para modelo ya cargado
        return Inertia::render('pacientes/show', [
            'paciente' => $paciente,
        ]);
    }

    public function edit(Paciente $paciente)
    {
        // Renderiza el formulario de edición con los datos del paciente
        return Inertia::render('pacientes/edit', [
            'paciente' => $paciente,
        ]);
    }

    public function update(Request $request, Paciente $paciente)
    {
        // Validar datos (misma validación que store, pero CURP no unique si no cambia)
        $validated = $request->validate([
            'curp' => [
                'required',
                'string',
                'max:18',
                'unique:pacientes,curp,' . $paciente->id // Ignora el registro actual en unique
            ],
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'sexo' => 'required|string|in:Masculino,Femenino',
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
            'estado_civil' => 'required|string|in:Soltero(a),Casado(a),Divorciado(a),Viudo(a),Union libre',
            'ocupacion' => 'required|string|max:100',
            'lugar_origen' => 'required|string|max:100',
            'nombre_padre' => 'nullable|string|max:100',
            'nombre_madre' => 'nullable|string|max:100',
        ]);

        // Actualizar paciente
        $paciente->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        // Eliminar paciente (asegúrate de manejar relaciones si es necesario, ej. estancias)
        $paciente->delete();

        // Redirigir con mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
