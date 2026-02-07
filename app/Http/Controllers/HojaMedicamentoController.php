<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Services\VentaService; 
use Illuminate\Support\Facades\DB;

use App\Models\HojaMedicamento;
use App\Models\Venta;
 
class HojaMedicamentoController extends Controller
{

    public function actualizarEstado(Request $request, HojaMedicamento $medicamento, VentaService $ventaService)
    {
        $validated = $request->validate([
            'estado' => 'required|string|in:surtido,entregado',
        ]);

        if ($medicamento->estado !== 'solicitado') {
            return Redirect::back()->with('error', 'Este medicamento ya fue procesado.');
        }

        DB::beginTransaction();
        try {
            $medicamento->load('hojaEnfermeria.formularioInstancia.estancia');
            $estanciaId = $medicamento->hojaEnfermeria->formularioInstancia->estancia->id;

            $itemParaVenta = [
                'id' => $medicamento->producto_servicio_id,
                'cantidad' => 1,
                'tipo' => 'producto' 
            ];

            $ventaExistente = Venta::where('estancia_id', $estanciaId)
                                  ->where('estado', Venta::ESTADO_PENDIENTE)
                                  ->first();

            if ($ventaExistente) {
                $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
            } else {
                $ventaService->crearVenta([$itemParaVenta], $estanciaId, Auth::id());
            }

            $medicamento->update([
                'estado' => $validated['estado'],
                'farmaceutico_id' => Auth::id(), 
                'fecha_hora_surtido_farmacia' => now(), 
            ]);

            DB::commit();
            return Redirect::back()->with('success', 'Medicamento surtido y añadido a la venta.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al surtir medicamento: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al surtir.');
        }
    }
}
