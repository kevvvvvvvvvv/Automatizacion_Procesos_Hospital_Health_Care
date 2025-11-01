<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use App\Models\HojaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Services\VentaService;

use App\Events\MedicamentosSolicitados;
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
    public function store(Request $request, HojaEnfermeria $hojasenfermeria, VentaService $ventaService)
    {
        DB::beginTransaction();
        try{
            $validatedData = $request->validate([
                'medicamentos_agregados' => 'required|array|min:1',
                'medicamentos_agregados.*.id' => 'required|exists:producto_servicios,id', 
                'medicamentos_agregados.*.dosis' => 'required|string|max:255',
                'medicamentos_agregados.*.via_id' => 'required|string|max:255',
                'medicamentos_agregados.*.gramaje' => 'required',
                'medicamentos_agregados.*.duracion' => 'required|numeric', 
                'medicamentos_agregados.*.unidad' => 'required',
            ]);

            $hojasenfermeria->load('formularioInstancia.estancia');
            $estanciaId = $hojasenfermeria->formularioInstancia->estancia->id;
            $itemsParaVenta = array_map(function ($med) {
                return [
                    'id' => $med['id'],
                    'cantidad' => $med['dosis'],
                ];
            }, $validatedData['medicamentos_agregados']);

            $venta = $ventaService->crearVenta($itemsParaVenta, $estanciaId, Auth::id());

            $medicamentosGuardados = collect();
            foreach ($validatedData['medicamentos_agregados'] as $med) {
                $producto = ProductoServicio::findOrFail($med['id']);
                if($med['dosis'] > $producto->cantidad){
                    DB::rollBack();
                    return redirect()->route('hojasenfermerias.edit',$hojasenfermeria)->with('error','No hay cantidad suficiente del medicamento '. $producto->nombre_prestacion);
                }

                $nuevoMedicamento = $hojasenfermeria->hojaMedicamentos()->create([
                    'producto_servicio_id' => $med['id'],
                    'dosis' => $med['dosis'],
                    'gramaje' => $med['gramaje'],
                    'via_administracion' => $med['via_id'],
                    'fecha_hora_solicitud' => now(),
                    'duracion_tratamiento' => $med['duracion'], 
                    'unidad' => $med['unidad'],
                    'hoja_enfermeria_id' => $hojasenfermeria->id,
                ]);
                $medicamentosGuardados->push($nuevoMedicamento);

            }

            $hojasenfermeria->load('formularioInstancia.estancia.paciente');
            $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;

            $usuariosFarmacia = User::role('farmacia')->get(); 

            Notification::send($usuariosFarmacia, 
                    new NuevaSolicitudMedicamentos(
                        $medicamentosGuardados, 
                        $paciente,
                        $hojasenfermeria->id
                    )
                );     
            
            DB::commit();
            return Redirect::back()->with('success', 'Medicamentos guardados exitosamente.');                                                           
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('hojasenfermerias.edit',$hojasenfermeria)->with('error','No se puedo realizar la petición de medicamento: ' . $e->getMessage());
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
