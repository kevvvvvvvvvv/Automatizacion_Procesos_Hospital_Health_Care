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
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductoServicioController extends Controller
{
    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json([
        'success' => false,
        'errors' => $validator->errors()
    ], 422));
}
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



 public function store(ProductoServicioRequest $request)
{
    return DB::transaction(function () use ($request) {
        // 1. Crear registro base (Esto guarda el Servicio siempre)
        $producto = ProductoServicio::create($request->validated());
       // dd($producto);
        $subtipo = strtoupper($request->subtipo);

        // 2. Lógica para hijos específicos
        if ($subtipo === 'MEDICAMENTOS') {
            $medicamento = Medicamento::create([
                'id' => $producto->id,
                'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                'volumen_total' => $request->volumen_total,
                'nombre_comercial' => $request->nombre_comercial,
                'gramaje' => $request->gramaje,
                'fraccion' => $request->fraccion ? 1 : 0,
            ]);

            if ($request->filled('viasAdministracion')) {
                $medicamento->vias()->sync($request->viasAdministracion);
            }
        } 
        elseif ($subtipo === 'ESTUDIOS') {
            // Solo entra aquí si es estudio, evitando el error de 'tipo_estudio' null en servicios
            $producto->estudio()->create([
                'id'             => $producto->id,
                'nombre'         => $request->nombre_prestacion ?? $request->nombre,
                'tipo_estudio'   => $request->tipo_estudio, 
                'departamento'   => $request->departamento,
                'tiempo_entrega' => $request->tiempo_entrega,
                'link'           => $request->link,
            ]);
        } 
        elseif ($subtipo === 'INSUMOS') {
            $producto->insumo()->create([
                'id' => $producto->id,
                'categoria' => $request->categoria,
                'especificacion' => $request->especificacion,
                'categoria_unitaria' => $request->categoria_unitaria,
            ]);
        }
        // Si es 'SERVICIOS', simplemente termina aquí y el commit guarda el ProductoServicio.

        return Redirect::route('producto-servicios.index')
            ->with('success', "Registro de {$subtipo} guardado correctamente.");
    });

}

    public function update(ProductoServicioRequest $request, ProductoServicio $productoServicio)
    {
        DB::transaction(function () use ($request, $productoServicio) {
            $productoServicio->update($request->validated());

            if ($productoServicio->subtipo === 'MEDICAMENTOS') {
            
            // CORRECCIÓN 1: Manejar el string "False" o "True" que viene del request
            $fraccion = filter_var($request->fraccion, FILTER_VALIDATE_BOOLEAN);

            $medicamento = $productoServicio->medicamento()->updateOrCreate(
                ['id' => $productoServicio->id],
                [
                    'excipiente_activo_gramaje' => $request->excipiente_activo_gramaje,
                    'volumen_total'             => $request->volumen_total,
                    'nombre_comercial'          => $request->nombre_comercial,
                    'gramaje'                   => $request->gramaje,
                    'fraccion'                  => $fraccion ? 1 : 0,
                ]
            );
            //dd($medicamento->toArray());
            // CORRECCIÓN 2: El dd() dice "via_administracion", no "viasAdministracion"
            // Y verificamos si el método en el modelo es 'vias' o 'viasAdministracion'
            $viasIds = $request->viasAdministracion ?? [];
            
            if (method_exists($medicamento, 'vias')) {
                $medicamento->vias()->sync($viasIds);
            } elseif (method_exists($medicamento, 'viasAdministracion')) {
                $medicamento->viasAdministracion()->sync($viasIds);
            }
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
        $productoServicio->load(['medicamento.viasAdministracion', 'insumo']);
        $viasSeleccionadas = [];
        
        if ($productoServicio->medicamento && $productoServicio->medicamento->vias) {
            $viasSeleccionadas = $productoServicio->medicamento->vias->pluck('id')->toArray();
        }

        return Inertia::render('producto-servicios/create', [
            'productoServicio'  => $productoServicio,
            'medicamentos'      => $productoServicio->medicamento, // Esto puede ser null
            'insumos'           => $productoServicio->insumo,      // Esto puede ser null
            'viasCatalogo'      => \App\Models\Inventario\CatalogoViaAdministracion::all(),
            'viasSeleccionadas' => $viasSeleccionadas
        ]);
    }

  


    public function destroy(ProductoServicio $productoServicio)
    {
        $productoServicio->delete();
        return Redirect::route('producto-servicios.index')->with('success', 'Eliminado correctamente.');
    }
}
