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
   public function store(TerapiaIVRequest $request)
    {
        $validatedData = $request->validated();

        $modelType = $request->input('terapiable_type');
        $modelId = $request->input('terapiable_id');

        if (!$modelType || !class_exists($modelType)) {
            return Redirect::back()->with('error', 'El tipo de formulario no es válido.');
        }

        try {
            DB::transaction(function () use ($validatedData, $modelType, $modelId) {
                $parent = $modelType::findOrFail($modelId);
                
                foreach ($validatedData['terapias_agregadas'] as $terapia) {
                    $nuevaTerapia = $parent->hojasTerapiaIV()->create([
                        'solucion' => $terapia['es_manual'] ? null : $terapia['solucion_id'],
                        'nombre_solucion' => $terapia['nombre_solucion'],
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
            \Log::error('Error al guardar terapia IV: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al registrar la terapia IV.');;
        }
    }

    public function update(Request $request, HojaTerapiaIV $hojasterapiasiv, VentaService $ventaService)
    {
        $validated = $request->validate([
            'fecha_hora_inicio' => ['required', 'date'],
        ]);

        $fechaOriginal = $hojasterapiasiv->getOriginal('fecha_hora_inicio');
        $fechaMySQL = Carbon::parse($validated['fecha_hora_inicio'])
                    ->setTimezone(config('app.timezone'))
                    ->format('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $esInicioTerapia = is_null($fechaOriginal) && !empty($fechaMySQL);

            if ($esInicioTerapia) {
                $producto = ProductoServicio::where('id', $hojasterapiasiv->solucion)
                                            ->lockForUpdate()
                                            ->first();

                if ($producto) {

                    $parent = $hojasterapiasiv->terapiable; 
                    $estanciaId = $parent->formularioInstancia->estancia->id;

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

                    $producto->decrement('cantidad', 1);
                }
            }

            $hojasterapiasiv->update(['fecha_hora_inicio' => $fechaMySQL]);

            DB::commit();
            return Redirect::back()->with('success', $esInicioTerapia ? 'Terapia iniciada y cargo aplicado.' : 'Actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar la terapia IV: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al actualizar la terapia IV.');
        }
    }
}