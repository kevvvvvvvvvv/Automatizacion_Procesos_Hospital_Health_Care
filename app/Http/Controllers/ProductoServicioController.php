<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoServicioRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoServicio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\CatalogoViaAdministracion;

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
        
        return Inertia::render('producto-servicios/create', [
            'productoServicio' => null,
            // Enviamos el catálogo para llenar el Select del frontend
            'viasCatalogo' => CatalogoViaAdministracion::all() 
        ]);
    }

   public function store(ProductoServicioRequest $request)
{
    DB::transaction(function () use ($request) {
        // 1. Crear producto principal
        $producto = ProductoServicio::create($request->validated());

        if ($request->subtipo === 'MEDICAMENTOS') {
            // 2. Crear el detalle del medicamento
            $medicamento = $producto->medicamento()->create([
                'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                'volumen_total'             => $request->volumen_total,
                'nombre_comercial'          => $request->nombre_comercial,
                'gramaje'                   => $request->gramaje,
                'fraccion'                  => $request->fraccion === 'True' ? 1 : 0,
            ]);

            // 3. Sincronizar múltiples vías (recibe el array de IDs desde React)
            if ($request->has('via_administracion')) {
                // sync() es perfecto para manejar arrays de IDs en tablas pivote
                $medicamento->vias()->sync($request->via_administracion);
            }

        } elseif ($request->subtipo === 'INSUMOS') {
            $producto->insumo()->create($request->validated());
        }
    });

    return Redirect::route('producto-servicios.index')->with('success', 'Registro completado.');
}

    public function edit(ProductoServicio $productoServicio) 
    {
        // Cargamos las relaciones para que el formulario se llene al editar
        $productoServicio->load(['medicamento.vias', 'insumo']);

        return Inertia::render('producto-servicios/create', [
            'productoServicio' => $productoServicio,
            'medicamentos' => $productoServicio->medicamento,
            'insumos' => $productoServicio->insumo,
            'viasCatalogo' => CatalogoViaAdministracion::all(),
            // Pasamos el ID de la vía actual si existe
            'viaActualId' => $productoServicio->medicamento?->vias->first()?->id
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
