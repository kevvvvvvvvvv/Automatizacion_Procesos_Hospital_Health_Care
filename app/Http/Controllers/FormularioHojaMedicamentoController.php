<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use App\Models\HojaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\VentaService;

use App\Events\MedicamentosSolicitados;
use App\Http\Requests\HojaMedicamentoRequest;
use App\Models\ProductoServicio;
use App\Models\User; 
use App\Models\Venta;
use App\Models\DetalleVenta;

use App\Notifications\NuevaSolicitudMedicamentos;
use Exception;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB; 

class FormularioHojaMedicamentoController extends Controller
{
    public function store(HojaMedicamentoRequest $request, HojaEnfermeria $hojasenfermeria, VentaService $ventaService)
    {
        $validatedData = $request->validated();
        
        try {
            $hojasenfermeria->load('formularioInstancia.estancia.paciente');
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
                } else {
                    $tieneStock = false; 
                }

                $nuevoMedicamento = $hojasenfermeria->hojaMedicamentos()->create([
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

            $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;
            $paciente->append('nombre_completo'); 

            $usuariosFarmacia = User::role('farmacia')->get(); 
            
            Notification::send($usuariosFarmacia, 
                    new NuevaSolicitudMedicamentos(
                        $medicamentosParaNotificacion, 
                        $paciente,
                        $hojasenfermeria->id
                    )
                );     
            
            return Redirect::back()->with('success', 'Solicitud de medicamentos enviada.');                                                           
        
        } catch(\Exception $e) {
            \Log::error('Error al guardar solicitud: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al guardar. ');
        }
    }

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaMedicamento $hojasmedicamento)
    {
        $validatedData = $request->validate([
            'fecha_hora_inicio' => 'required|date',
        ]);

        $fechaMySQL = Carbon::parse($validatedData['fecha_hora_inicio'])
                            ->setTimezone(config('app.timezone')) 
                            ->format('Y-m-d H:i:s'); 

        $hojasmedicamento->update([
            'fecha_hora_inicio' => $fechaMySQL,
        ]);
        
        return Redirect::back()->with('success', 'Fecha de medicamento actualizada.');
    }
}
