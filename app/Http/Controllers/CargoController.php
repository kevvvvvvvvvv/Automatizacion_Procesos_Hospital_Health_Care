<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CargoController extends Controller
{

    public function index()
    {
        $cargos = Cargo::select('id', 'nombre')->orderBy('nombre')->get();
        return Inertia::render('Cargos/Index', compact('cargos')); 

    }

    public function store(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cargos', 'nombre'), // Evita duplicados
            ],

        ], [
            'nombre.required' => 'El nombre del cargo es obligatorio.',
            'nombre.unique' => 'Este cargo ya existe.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ]);

        $cargo = Cargo::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cargo creado exitosamente.',
            'cargo' => $cargo->only(['id', 'nombre']), 
        ]);
    }

    public function show(Cargo $cargo)
    {
        return Inertia::render('Cargos/Show', compact('cargo'));
    }

    public function update(Request $request, Cargo $cargo): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cargos', 'nombre')->ignore($cargo->id),
            ],
        ]);

        $cargo->update($validated);

        return response()->json([
            'success' => true,
            'cargo' => $cargo->only(['id', 'nombre']),
        ]);
    }

    public function destroy(Cargo $cargo): JsonResponse
    {
        $cargo->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cargo eliminado.',
        ]);
    }
}
