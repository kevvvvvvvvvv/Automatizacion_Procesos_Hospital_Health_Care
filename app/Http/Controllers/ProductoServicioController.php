<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoServicioRequest;
use App\Http\Request\MedicamentoRequest;
use App\Http\Request\InsumoRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoServicio;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Models\CatalogoViaAdministracion;

class ProductoServicioController extends Controller
{
    public function index()
    {
        // Cargamos relaciones para ver detalles en la tabla si es necesario
        $productoServicios = ProductoServicio::with(['medicamento', 'insumo'])->get(); 

        return Inertia::render('producto-servicios/index', [
            'productoServicios' => $productoServicios 
        ]);
    }

    public function create()
    {
        return Inertia::render('producto-servicios/create', [
            'productoServicio' => null,
            'viasCatalogo' => CatalogoViaAdministracion::all() 
        ]);
    }

    public function store(ProductoServicioRequest $request)
{

    DB::transaction(function () use ($request) {

        // 🔹 Crear producto principal
        $producto = ProductoServicio::create($request->validated());

        // ================= MEDICAMENTO =================
        if ($request->subtipo === 'MEDICAMENTOS') {

            $medicamento = $producto->medicamento()->create([
                'id' => $producto->id,
                'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                'volumen_total' => $request->volumen_total,
                'nombre_comercial' => $request->nombre_comercial,
                'gramaje' => $request->gramaje,
                'fraccion' => $request->fraccion == true ? 1 : 0,
            ]);

            // vias admin
            if ($request->via_administracion) {
                $medicamento->vias()->sync($request->via_administracion);
            }
        }

        // ================= INSUMO =================
        elseif ($request->subtipo === 'INSUMOS') {

            $producto->insumo()->create([
                'id' => $producto->id,
                'categoria' => $request->categoria,
                'especificacion' => $request->especificacion,
                'categoria_unitaria' => $request->categoria_unitaria,
            ]);
        }
    });

    return Redirect::route('producto-servicios.index')
        ->with('success', 'Registro completado correctamente');
}


    public function edit(ProductoServicio $productoServicio) 
    {
        // Cargamos las relaciones para llenar el formulario
        $productoServicio->load(['medicamento.vias', 'insumo']);

        return Inertia::render('producto-servicios/create', [
            'productoServicio'  => $productoServicio,
            'medicamentos'      => $productoServicio->medicamento,
            'insumos'           => $productoServicio->insumo,
            'viasCatalogo'      => CatalogoViaAdministracion::all(),
            // Extraemos los IDs de las vías actuales para el multiselect
            'viasSeleccionadas' => $productoServicio->medicamento?->vias->pluck('id')->toArray() ?? []
        ]);
    }

   public function update(ProductoServicioRequest $request, ProductoServicio $productoServicio)
{
    DB::transaction(function () use ($request, $productoServicio) {

        $productoServicio->update($request->validated());

        // ===== MEDICAMENTO =====
        if ($productoServicio->subtipo === 'MEDICAMENTOS') {

            $medicamento = $productoServicio->medicamento()->updateOrCreate(
                ['id' => $productoServicio->id],
                [
                    'id' => $productoServicio->id,
                    'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                    'volumen_total' => $request->volumen_total,
                    'nombre_comercial' => $request->nombre_comercial,
                    'gramaje' => $request->gramaje,
                    'fraccion' => $request->fraccion ? 1 : 0,
                ]
            );

            $medicamento->vias()->sync($request->via_administracion ?? []);
        }

        // ===== INSUMO =====
        elseif ($productoServicio->subtipo === 'INSUMOS') {

            $productoServicio->insumo()->updateOrCreate(
                ['id' => $productoServicio->id],
                [
                    'id' => $productoServicio->id,
                    'categoria' => $request->categoria,
                    'especificacion' => $request->especificacion,
                    'categoria_unitaria' => $request->categoria_unitaria,
                ]
            );
        }
    });

    return Redirect::route('producto-servicios.index')
        ->with('success', 'Actualizado correctamente');
}



    public function destroy(ProductoServicio $productoServicio)
    {
        $productoServicio->delete();
        return Redirect::route('producto-servicios.index')->with('success', 'Eliminado correctamente.');
    }
}