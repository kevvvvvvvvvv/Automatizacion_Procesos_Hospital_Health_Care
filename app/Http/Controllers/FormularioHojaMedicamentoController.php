<?php

namespace App\Http\Controllers;
use App\Models\Venta\Venta; // Importante añadir esta

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\VentaService;
use Illuminate\Support\Facades\DB;

use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;
use App\Models\Formulario\HojaEnfermeria\HojaMedicamento;
use App\Http\Requests\HojaMedicamentoRequest;
use App\Models\Inventario\ProductoServicio;
use App\Models\User; 

use App\Notifications\NuevaSolicitudMedicamentos;
use Exception;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class FormularioHojaMedicamentoController extends Controller
{
   public function store(HojaMedicamentoRequest $request, VentaService $ventaService)
    {
        $validatedData = $request->validated();
        
        $modelType = $request->input('medicable_type'); 
        $modelId = $request->input('medicable_id');;

        if (!$modelType || !class_exists($modelType)) {
            return redirect()->back()->with('error', 'El tipo de formulario no es válido.');
        }

        try {
            $parent = $modelType::findOrFail($modelId);
            $medicamentosParaNotificacion = collect();

            foreach ($validatedData['medicamentos_agregados'] as $med) {
                $productoId = $med['id'] ?? null; 
                $nombreSnapshot = $med['nombre_medicamento']; 
                $producto = null;
                $tieneStock = false;

                if ($productoId) {
                    $producto = ProductoServicio::find($productoId);
                    if ($producto) {
                        $tieneStock = ($producto->cantidad >= 1) && ($producto->tipo !== 'SERVICIO');
                    }
                }

               

                $nuevoMedicamento = $parent->hojaMedicamentos()->create([
                    'producto_servicio_id' => $productoId, 
                    'nombre_medicamento'   => $nombreSnapshot, 
                    'dosis'                => $med['dosis'],
                    'gramaje'              => $med['gramaje'],
                    'via_administracion'   => $med['via_id'],
                    'fecha_hora_solicitud' => now(),
                    'duracion_tratamiento' => $med['duracion'], 
                    'unidad'               => $med['unidad'], 
                    'estado'               => 'solicitado', 
                ]);

                if ($nuevoMedicamento->producto_servicio_id) {
                    $nuevoMedicamento->load('productoServicio');
                }

                $medicamentosParaNotificacion->push([
                    'medicamento' => $nuevoMedicamento, 
                    'tiene_stock' => $tieneStock,
                    'es_manual'   => is_null($productoId) 
                ]);
            }

            $instancia = $parent->formularioInstancia;
            $paciente = $instancia->estancia->paciente;
            $paciente->append('nombre_completo'); 

            $usuariosFarmacia = User::role('farmacia')->get(); 
            
            Notification::send($usuariosFarmacia, 
                new NuevaSolicitudMedicamentos(
                    $medicamentosParaNotificacion, 
                    $paciente,
                    $parent->id 
                )
            );     
            
            return Redirect::back()->with('success', 'Solicitud de medicamentos enviada.');                                                                      
        
        } catch(\Exception $e) {
            \Log::error('Error al guardar solicitud: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaMedicamento $hojasmedicamento, VentaService $ventaService)
    {
        $validatedData = $request->validate([
            'fecha_hora_inicio' => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            
            $fechaMySQL = Carbon::parse($validatedData['fecha_hora_inicio'])
                                ->setTimezone(config('app.timezone')) 
                                ->format('Y-m-d H:i:s'); 

                
                $hojasmedicamento->load('medicable.formularioInstancia.estancia');
                $estanciaId = $hojasmedicamento->medicable->formularioInstancia->estancia->id;
                
                $itemParaVenta = [
                    'id'       => $hojasmedicamento->producto_servicio_id ?? null,
                    'cantidad' => 1,
                    'tipo'     => 'medicamento',
                    'nombre'   => $hojasmedicamento->nombre_medicamento,
                ];

                $ventaExistente = Venta::where('estancia_id', $estanciaId)
                                      ->where('estado', Venta::ESTADO_PENDIENTE)
                                      ->first();

                if ($ventaExistente) {
                    $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
                } else {
                    $ventaService->crearVenta([$itemParaVenta], $estanciaId, Auth::id());
                }

       
            $hojasmedicamento->update([
                'fecha_hora_inicio' => $fechaMySQL,
            ]);

            DB::commit();
            return Redirect::back()->with('success', 'Fecha actualizada y cargo aplicado a la cuenta.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar medicamento: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al procesar la actualización.');
        }
    }
}
