<?php

namespace App\Http\Controllers;
use App\Models\Interconsulta;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use Illuminate\Http\Request;

class InterconsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
     {
         $pacientes = Paciente::select('id', DB::raw('CONCAT(nombre, " ", apellido_paterno, " ", apellido_materno) as nombre_completo'))->get();
         return Inertia::render('formularios/interconsulta/create', compact('pacientes'));
     }

    /**
     * Store a newly created resource in storage.
     */
         public function store(Request $request)
     {
         $validated = $request->validate([
             'paciente_id' => 'required|exists:pacientes,id',
             'ta' => 'nullable|string|max:20',
             'fc' => 'nullable|integer|min:0',
             'fr' => 'nullable|integer|min:0',
             'temp' => 'nullable|numeric|min:0',
             'peso' => 'nullable|numeric|min:0',
             'talla' => 'nullable|numeric|min:0',
             // Para texts: 'nullable|string|max:65535' (límite de text en MySQL)
             'criterio_diagnostico' => 'nullable|string',
             // ... similar para otros texts
         ]);

         Interconsulta::create($validated);

         return redirect()->route('pacientes.show', $validated['paciente_id'])->with('success', 'Interconsulta creada exitosamente.');
     }
     

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
