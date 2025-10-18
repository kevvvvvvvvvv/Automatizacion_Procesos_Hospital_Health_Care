<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoServicioRequest;
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
        return Inertia::render('producto-servicios/create');
    }

    public function store(ProductoServicioRequest $request)
    {
        ProductoServicio::create($request->validated());

        return Redirect::route('producto-servicios.index')
            ->with('success','Producto o servicio registrado');
    }

    public function edit(ProductoServicio $productoServicio) 
    {
        return Inertia::render('producto-servicios/edit', [ 
            'productoServicio' => $productoServicio
        ]);
    }

    public function update(ProductoServicioRequest $request, ProductoServicio $productoServicio)
    {
        $productoServicio->update($request->validated());

        return Redirect::route('producto-servicios.index')
            ->with('success', 'Producto o servicio actualizado exitosamente.');
    }

    public function delete()
    {
        
    }
    
}
