<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Http\Requests\Formulario\HojaEnfermeria\TerapiaIV\TerapiaIVRequest;

use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Formulario\HojaEnfermeria\HojaTerapiaIV;
use App\Models\Venta\Venta;
use App\Services\VentaService;
use App\Models\Inventario\ProductoServicio;

class FormularioHojaTerapiaIVController extends Controller
{
    public function store(TerapiaIVRequest $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validated();
        try {
            DB::transaction(function () use ($validatedData, $hojasenfermeria) {
                
                foreach ($validatedData['terapias_agregadas'] as $terapia) {
                    $nuevaTerapia = $hojasenfermeria->hojasTerapiaIV()->create([
                        'solucion' => $terapia['es_manual'] ? null : $terapia['solucion_id'],
                        'solucion_nombre' => $terapia['solucion_nombre'],
                        'flujo_ml_hora' => $terapia['flujo'],
                        'fecha_hora_inicio' => $terapia['fecha_hora_inicio'] ?? null,
                        'duracion' => $terapia['duracion'],
                        'cantidad' => $terapia['cantidad'],
                    ]);

                    if (!empty($terapia['medicamentos'])) {
                        foreach ($terapia['medicamentos'] as $medicamento) {
                            $nuevaTerapia->medicamentos()->create([
                                'producto_servicio_id' => $medicamento['es_manual'] ? null : $medicamento['id'],
                                'nombre_medicamento' => $medicamento['nombre'],
                                'dosis' => $medicamento['dosis'],
                                'unidad_medida' => $medicamento['unidad'],
                            ]);
                            
                        }
                    }
                }
            });

            return Redirect::back()->with('success', 'Terapias y medicamentos guardados exitosamente.');

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