<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV;
use App\Models\Venta\Venta;
use App\Services\VentaService;
use App\Models\Inventario\ProductoServicio;

class FormularioHojaTerapiaIVController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validate([
            'terapias_agregadas' => 'required|array|min:1',
            'terapias_agregadas.*.solucion_id' => 'required|exists:producto_servicios,id',
            'terapias_agregadas.*.cantidad' => 'required|numeric',
            'terapias_agregadas.*.duracion' => 'required|numeric',
            'terapias_agregadas.*.flujo' => 'required|numeric',
        ]);

        try {
            foreach ($validatedData['terapias_agregadas'] as $terapia) {
                $hojasenfermeria->hojasTerapiaIV()->create([
                    'solucion' => $terapia['solucion_id'],
                    'flujo_ml_hora' => $terapia['flujo'],
                    'fecha_hora_inicio' => $terapia['fecha_hora_inicio'] ?? null,
                    'duracion' => $terapia['duracion'],
                    'cantidad' => $terapia['cantidad'],
                ]);
            }
            return Redirect::back()->with('success', 'Terapias guardadas exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al guardar Terapia IV: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al guardar las terapias.');
        }
    }

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaTerapiaIV $hojasterapiasiv, VentaService $ventaService)
    {
        $validated = $request->validate([
            'fecha_hora_inicio' => ['required', 'date'],
        ]);

        // 1. Detectar el estado ORIGINAL antes de actualizar
        $fechaOriginal = $hojasterapiasiv->getOriginal('fecha_hora_inicio');
        
        $fechaMySQL = Carbon::parse($validated['fecha_hora_inicio'])
                    ->setTimezone(config('app.timezone'))
                    ->format('Y-m-d H:i:s');

        if ($hojasterapiasiv->hoja_enfermeria_id !== $hojasenfermeria->id) {
            abort(403, 'Acción no autorizada.');
        }

        DB::beginTransaction();
        try {

            $esInicioTerapia = is_null($fechaOriginal) && !empty($fechaMySQL);

            if ($esInicioTerapia) {
                $producto = ProductoServicio::where('id', $hojasterapiasiv->solucion)
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

            $hojasterapiasiv->update([
                'fecha_hora_inicio' => $fechaMySQL,
            ]);

            DB::commit();
            
            $mensaje = $esInicioTerapia 
                ? 'Terapia iniciada: Cargo aplicado y stock actualizado.' 
                : 'Fecha de terapia actualizada.';

            return Redirect::back()->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar Terapia IV: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al procesar la actualización.');
        }
    }
}