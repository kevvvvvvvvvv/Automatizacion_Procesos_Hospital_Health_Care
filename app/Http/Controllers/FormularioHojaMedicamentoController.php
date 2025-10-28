<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use App\Models\HojaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Events\MedicamentosSolicitados;

class FormularioHojaMedicamentoController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria)
    {

        $validatedData = $request->validate([
            'medicamentos_agregados' => 'required|array|min:1',
            'medicamentos_agregados.*.id' => 'required|exists:producto_servicios,id', 
            'medicamentos_agregados.*.dosis' => 'required|string|max:255',
            'medicamentos_agregados.*.via_id' => 'required|string|max:255',
            'medicamentos_agregados.*.duracion' => 'nullable|numeric', 
            'medicamentos_agregados.*.inicio' => 'required|date', 
        ]);

        $medicamentosGuardados = collect();

        foreach ($validatedData['medicamentos_agregados'] as $med) {

            $nuevoMedicamento = $hojasenfermeria->hojaMedicamentos()->create([
                'producto_servicio_id' => $med['id'],
                'dosis' => $med['dosis'],
                'via_administracion' => $med['via_id'],
                'fecha_hora_solicitud' => now(),
                'duracion_tratamiento' => $med['duracion'], 
                'hoja_enfermeria_id' => $hojasenfermeria->id,
            ]);
            $medicamentosGuardados->push($nuevoMedicamento);
        }

        $medicamentosGuardados->load('productoServicio'); 

        $hojasenfermeria->load('formularioInstancia.estancia.paciente');
        $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;

        broadcast(new MedicamentosSolicitados($medicamentosGuardados, $paciente))->toOthers();

        return Redirect::back()->with('success', 'Medicamentos guardados exitosamente.');
    }

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaMedicamento $hojasmedicamento)
    {
        $hojasmedicamento->update([
            'fecha_hora_inicio'=>$request->fecha_hora_inicio
        ]);

        return Redirect::back()->with('success', 'Fecha de medicamento actualizada.');
    }
}
