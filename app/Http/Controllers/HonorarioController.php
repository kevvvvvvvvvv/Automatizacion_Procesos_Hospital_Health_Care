<?php

namespace App\Http\Controllers;

use App\Models\Honorario;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Interconsulta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HonorarioController extends Controller
{
    public function index(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta)
    {
        $honorarios = $interconsulta->honorarios;  // Asumiendo que tienes la relación en Interconsulta
        return Inertia::render('formularios/interconsulta/honorarios/show', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'interconsulta' => $interconsulta,
            'honorarios' => $honorarios,
        ]);
    }

    public function create(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta)
    {
        return Inertia::render('formularios/interconsulta/honorarios/create', [ 
            'paciente' => $paciente,
            'estancia' => $estancia,
            'interconsulta' => $interconsulta,
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta)
    {
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $honorario = Honorario::create([
            'interconsulta_id' => $interconsulta->id,
            'monto' => $validated['monto'],
            'descripcion' => $validated['descripcion'],
        ]);

          return redirect()->route('pacientes.estancias.interconsultas.show', [
        'paciente' => $paciente->id,
        'estancia' => $estancia->id,
        'interconsulta' => $interconsulta->id,
    ])->with('success', 'Honorario creado exitosamente.');
    }

   public function show(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta, Honorario $honorario)
    {
        
        return Inertia::render('honorarios/show', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'interconsulta' => $interconsulta,
            'honorario' => $honorario,  // Asegúrate de que esto se pase
            
        ]);
        dd($honorario);
    }


    public function edit(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta, Honorario $honorario)
    {
        return Inertia::render('formularios/interconsulta/honorarios/edit', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'interconsulta' => $interconsulta,
            'honorario' => $honorario,
        ]);
    }

    public function update(Request $request, Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta, Honorario $honorario)
    {
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $honorario->update($validated);

        return redirect()->route('pacientes.estancias.interconsultas.honorarios.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'interconsulta' => $interconsulta->id,
            'honorario' => $honorario->id,
        ])->with('success', 'Honorario actualizado exitosamente.');
    }

    public function destroy(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta, Honorario $honorario)
    {
        $honorario->delete();
        return redirect()->route('pacientes.estancias.interconsultas.honorarios.index', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'interconsulta' => $interconsulta->id,
        ])->with('success', 'Honorario eliminado exitosamente.');
    }
}