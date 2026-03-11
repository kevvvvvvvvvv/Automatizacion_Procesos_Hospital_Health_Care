<?php

namespace App\Http\Controllers;




use App\Http\Requests\HojaSondaCateteresRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Formulario\HojaEnfermeria\HojaSondaCateter;
use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Venta\Venta;
use App\Services\VentaService;

use Carbon\Carbon;

class FormularioHojaSondaCateterController extends Controller
{
    public function store(HojaSondaCateteresRequest $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validated();
        
        try {
            HojaSondaCateter::create([
                ...$validatedData,
                'user_id' => Auth::id(),
                'hoja_enfermeria_id' => $hojasenfermeria->id
            ]);

            return Redirect::back()->with('success', 'Información guardada correctamente');

        } catch (\Exception $e) {
            \Log::error('Error al registrar la sonda o cateter: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al registrar la sonda o cateter.');
        }
    }

  public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaSondaCateter $hojassondascateter, VentaService $ventaService)
{
    // 1. Obtener datos originales ANTES de aplicar cambios
    // Esto nos asegura saber qué había en la DB realmente
    $fechaOriginal = $hojassondascateter->getOriginal('fecha_instalacion');
    
    $data = $request->all();

    // Procesar Fechas
    if ($request->has('fecha_instalacion') && $request->fecha_instalacion) {
        $data['fecha_instalacion'] = Carbon::parse($request->fecha_instalacion)
                                        ->setTimezone(config('app.timezone'));
    }

    if ($request->has('fecha_caducidad') && $request->fecha_caducidad) {
        $data['fecha_caducidad'] = Carbon::parse($request->fecha_caducidad)
                                        ->setTimezone(config('app.timezone'));
    }

    DB::beginTransaction();

    try {
        
        $esPrimerRegistroDeInstalacion = is_null($fechaOriginal) && !empty($data['fecha_instalacion']);

        if ($esPrimerRegistroDeInstalacion) {
            
            $productoId = $request->producto_servicio_id ?? $hojassondascateter->producto_servicio_id;

            if ($productoId) {
                $producto = \App\Models\Inventario\ProductoServicio::where('id', $productoId)
                                                                  ->lockForUpdate()
                                                                  ->first();

                if ($producto) {
                    $hojasenfermeria->load('formularioInstancia.estancia');
                    $estanciaId = $hojasenfermeria->formularioInstancia->estancia->id;

                    $itemParaVenta = [
                        'id'       => $producto->id,
                        'cantidad' => 1,
                        'tipo'     => 'producto',
                        'nombre'   => $producto->nombre_prestacion,
                    ];

                    $ventaExistente = Venta::where('estancia_id', $estanciaId)
                                          ->where('estado', Venta::ESTADO_PENDIENTE)
                                          ->first();

                    if ($ventaExistente) {
                        $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
                    } else {
                        $ventaService->crearVenta([$itemParaVenta], $estanciaId, Auth::id());
                    }

                    $producto->decrement('cantidad', 0);
                }
            }
        }

        $hojassondascateter->update($data);

        DB::commit();
        
        return Redirect::back()->with('success', 'Proceso completado correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error en update de Sonda/Cateter: ' . $e->getMessage());
        return Redirect::back()->with('error', 'Error al procesar el registro: ' . $e->getMessage());
    }
}
    
}