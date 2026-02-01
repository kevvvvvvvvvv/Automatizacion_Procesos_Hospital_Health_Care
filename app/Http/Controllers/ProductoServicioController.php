<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoServicioRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

class ProductoServicioController extends Controller
{
    public function index()
    {
        $productoServicios = ProductoServicio::all(); 

        return Inertia::render('producto-servicios/index', [
            'productoServicios' => $productoServicios 
        ]);
    }


    public function create()
    {
        return Inertia::render('producto-servicios/create', ['productoServicio' => null,
        ]);
    }



    public function store(ProductoServicioRequest $request)
    {
        DB::transaction(function () use ($request) {
            // 1. Guardar en la tabla principal
            $producto = ProductoServicio::create($request->validated());

            // 2. Guardar en tablas específicas según el subtipo
            if ($request->subtipo === 'MEDICAMENTOS') {
                $producto->medicamento()->create($request->only([
                    'excipiente_activo_gramaje', 'volumen_total', 'nombre_comercial', 'gramaje', 'fraccion'
                ]));
            } elseif ($request->subtipo === 'INSUMOS') {
                $producto->insumo()->create($request->only([
                    'categoria', 'especificacion', 'categoria_unitaria'
                ]));
            }
        });

        return Redirect::route('producto-servicios.index')
            ->with('success', 'Registrado exitosamente');
    }

    public function edit(ProductoServicio $productoServicio) 
    {
        return Inertia::render('producto-servicios/create', [
            'productoServicio' => $productoServicio,
        ]);
    }

    public function update(ProductoServicioRequest $request, ProductoServicio $productoServicio)
    {
        DB::transaction(function () use ($request, $productoServicio) {
            $productoServicio->update($request->validated());

            if ($request->subtipo === 'MEDICAMENTOS') {
                $productoServicio->medicamento()->updateOrCreate(
                    ['id' => $productoServicio->id],
                    $request->only(['excipiente_activo_gramaje', 'nombre_comercial', /*...*/])
                );
            }
            // Repetir lógica para Insumos...
        });

        return Redirect::route('producto-servicios.index')->with('success', 'Actualizado');
    }

    public function delete()
    {
        
    }
    
}
