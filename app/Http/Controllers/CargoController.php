<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource (para pasar cargos al frontend).
     */
    public function index()
    {
        $cargos = Cargo::select('id', 'nombre')->orderBy('nombre')->get();
        return Inertia::render('Cargos/Index', compact('cargos')); // O tu vista; para Inertia
        // Si usas API-like: return response()->json($cargos);
    }

    /**
     * Store a newly created resource in storage (CREACIÓN DE CARGO).
     */
    public function store(Request $request): JsonResponse
    {
        // Validación
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cargos', 'nombre'), // Evita duplicados
            ],
            // 'descripcion' => 'nullable|string|max:500', // Si agregas este campo al modelo
        ], [
            'nombre.required' => 'El nombre del cargo es obligatorio.',
            'nombre.unique' => 'Este cargo ya existe.',
            'nombre.max' => 'El nombre no puede exceder 255 caracteres.',
        ]);

        // Crear el cargo
        $cargo = Cargo::create($validated);

        //return route()->withResponse

        // Respuesta JSON para el frontend (Inertia lo maneja bien)
        return response()->json([
            'success' => true,
            'message' => 'Cargo creado exitosamente.',
            'cargo' => $cargo->only(['id', 'nombre']), // Retorna el cargo nuevo con ID real
        ]);
    }

    // Opcionales: Otros métodos si los necesitas (e.g., para editar/eliminar)
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
        $cargo->delete(); // Opcional: Verifica si tiene usuarios asignados antes de borrar

        return response()->json([
            'success' => true,
            'message' => 'Cargo eliminado.',
        ]);
    }
}
