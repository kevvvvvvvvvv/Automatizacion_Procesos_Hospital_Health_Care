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
            'curp' => 'required|string|max:18',
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
        $paciente = Paciente::with('estancias')->findOrFail($paciente->id);
        return Inertia::render('pacientes/show', [
            'paciente' => $paciente,
        ]);
    }
}
