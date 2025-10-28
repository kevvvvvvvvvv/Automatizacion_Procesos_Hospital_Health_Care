<?php

namespace App\Http\Controllers;

use App\Models\Honorario;
use App\Models\Interconsulta;
use App\Http\Requests\HonorarioRequest; // Importa la clase de validación que crearemos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class HonorarioController extends Controller
{
    /**
     * Display a listing of the honorarios.
     * Opcionalmente, puedes filtrar por interconsulta_id si se pasa como parámetro.
     */
    public function index(Request $request)
    {
        $query = Honorario::with('interconsulta');

        if ($request->has('interconsulta_id') && $request->interconsulta_id) {
            $query->where('interconsulta_id', $request->interconsulta_id);
        }

        $honorarios = $query->paginate(10); // O usa get() si no quieres paginación

        return Inertia::render('honorarios/index', [
            'honorarios' => $honorarios,
            'interconsulta_id' => $request->interconsulta_id,
        ]);
    }

    /**
     * Show the form for creating a new honorario.
     */
    public function create(Request $request)
    {
        $interconsulta = null;
        if ($request->has('interconsulta_id')) {
            $interconsulta = Interconsulta::find($request->interconsulta_id);
        }

        return Inertia::render('honorarios/create', [
            'interconsulta' => $interconsulta,
        ]);
    }

    /**
     * Store a newly created honorario in storage.
     */
    public function store(HonorarioRequest $request)
    {
        Honorario::create($request->validated());

        return Redirect::back()->with('success', 'Honorario creado exitosamente.');
    }

    /**
     * Display the specified honorario.
     */
    public function show(Honorario $honorario)
    {
        $honorario->load('interconsulta');

        return Inertia::render('honorarios/show', [
            'honorario' => $honorario,
        ]);
    }

    /**
     * Show the form for editing the specified honorario.
     */
    public function edit(Honorario $honorario)
    {
        $interconsultas = Interconsulta::all();

        return Inertia::render('honorarios/edit', [
            'honorario' => $honorario,
            'interconsultas' => $interconsultas,
        ]);
    }

    /**
     * Update the specified honorario in storage.
     */
    public function update(HonorarioRequest $request, Honorario $honorario)
    {
        $honorario->update($request->validated());

        return Redirect::back()->with('success', 'Honorario actualizado exitosamente.');
    }

    /**
     * Remove the specified honorario from storage.
     */
    public function destroy(Honorario $honorario)
    {
        $honorario->delete();

        return Redirect::back()->with('success', 'Honorario eliminado exitosamente.');
    }
}