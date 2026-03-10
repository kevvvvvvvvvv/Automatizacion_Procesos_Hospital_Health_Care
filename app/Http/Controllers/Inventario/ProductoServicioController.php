<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoServicioRequest;
use App\Http\Request\MedicamentoRequest;
use App\Http\Request\InsumoRequest; 
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;

use App\Models\Inventario\CatalogoViaAdministracion;
use App\Models\Inventario\ProductoServicio;
use App\Models\Inventario\Medicamento;
use App\Models\Estudio\CatalogoEstudios;

class ProductoServicioController extends Controller
{
    public function index()
    {
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

    // ... (cabecera del controlador igual)

    public function store(ProductoServicioRequest $request)
    {
        return DB::transaction(function () use ($request) {
            // 1. Creamos el registro base
            $producto = ProductoServicio::create($request->validated());

            if ($request->subtipo === 'MEDICAMENTOS') {
                $medicamento = $producto->medicamento()->create([
                    'id' => $producto->id,
                    'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                    'volumen_total' => $request->volumen_total,
                    'nombre_comercial' => $request->nombre_comercial,
                    'gramaje' => $request->gramaje,
                    'fraccion' => $request->fraccion ? 1 : 0,
                ]);

                if ($request->via_administracion) {
                    $medicamento->vias()->sync($request->via_administracion);
                }
            } 
            elseif ($request->subtipo === 'ESTUDIOS') {
                // SOLUCIÓN AL ERROR 1364: Agregamos 'nombre'
                $producto->estudio()->create([
                    'id'             => $producto->id,
                    'nombre'         => $request->nombre_prestacion, // <-- IMPORTANTE
                    'tipo_estudio'   => $request->tipo_estudio,
                    'departamento'   => $request->departamento,
                    'tiempo_entrega' => $request->tiempo_entrega,
                    'link'           => $request->link,
                ]);
            } 
            elseif ($request->subtipo === 'INSUMOS') {
                $producto->insumo()->create([
                    'id' => $producto->id,
                    'categoria' => $request->categoria,
                    'especificacion' => $request->especificacion,
                    'categoria_unitaria' => $request->categoria_unitaria,
                ]);
            }
            
            return Redirect::route('producto-servicios.index')
                ->with('success', 'Registro completado correctamente');
        });
    }

    public function update(ProductoServicioRequest $request, ProductoServicio $productoServicio)
    {
        DB::transaction(function () use ($request, $productoServicio) {
            $productoServicio->update($request->validated());

            if ($productoServicio->subtipo === 'MEDICAMENTOS') {
                $medicamento = $productoServicio->medicamento()->updateOrCreate(
                    ['id' => $productoServicio->id],
                    [
                        'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                        'volumen_total' => $request->volumen_total,
                        'nombre_comercial' => $request->nombre_comercial,
                        'gramaje' => $request->gramaje,
                        'fraccion' => $request->fraccion ? 1 : 0,
                    ]
                );
                $medicamento->vias()->sync($request->via_administracion ?? []);
            } 
            elseif ($productoServicio->subtipo === 'ESTUDIOS') {
                // CORRECCIÓN: Usar $productoServicio y updateOrCreate
                $productoServicio->estudio()->updateOrCreate(
                    ['id' => $productoServicio->id],
                    [
                        'nombre'         => $request->nombre_prestacion, // <-- También aquí
                        'tipo_estudio'   => $request->tipo_estudio,
                        'departamento'   => $request->departamento,
                        'tiempo_entrega' => $request->tiempo_entrega,
                        'link'           => $request->link,
                    ]
                );
            }
            elseif ($productoServicio->subtipo === 'INSUMOS') {
                $productoServicio->insumo()->updateOrCreate(
                    ['id' => $productoServicio->id],
                    [
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

    public function edit(ProductoServicio $productoServicio) 
    {
        $productoServicio->load(['medicamento.vias', 'insumo']);

        return Inertia::render('producto-servicios/create', [
            'productoServicio'  => $productoServicio,
            'medicamentos'      => $productoServicio->medicamento,
            'insumos'           => $productoServicio->insumo,
            'viasCatalogo'      => CatalogoViaAdministracion::all(),
            'viasSeleccionadas' => $productoServicio->medicamento?->vias->pluck('id')->toArray() ?? []
        ]);
    }

  


    public function destroy(ProductoServicio $productoServicio)
    {
        $productoServicio->delete();
        return Redirect::route('producto-servicios.index')->with('success', 'Eliminado correctamente.');
    }
}
