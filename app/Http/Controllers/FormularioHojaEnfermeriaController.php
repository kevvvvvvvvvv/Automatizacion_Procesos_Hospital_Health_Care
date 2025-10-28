<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\HojaEnfermeria;
use App\Models\ProductoServicio;
use App\Models\HojaMedicamento;
use App\Models\HojaSignos;
use Illuminate\Support\Facades\Auth;

use Inertia\Inertia;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB; 

class FormularioHojaEnfermeriaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $soluciones = ProductoServicio::where('subtipo','INSUMOS')->get();

        return Inertia::render('formularios/hojas-enfermerias/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => HojaEnfermeria::CATALOGO_ID,
                'user_id' =>  Auth::id(),
            ]);

             
            $hoja = HojaEnfermeria::create([
                'id' => $formulario->id,
                'turno' => $request->turno, 
                'observaciones' => $request->observaciones,
                'estado' => 'Abierto',
            ]);
            
            
            DB::commit();

            
            return Redirect::route('hojasenfermerias.edit', $hoja->id)
                   ->with('success', 'Turno iniciado. Ya puede registrar eventos.');

        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error', 'Error al iniciar turno: ' . $e->getMessage());
        }
    }

    public function edit(HojaEnfermeria $hojasenfermeria)
    {

        $hojasenfermeria->load(
            'formularioInstancia.estancia.paciente', 
            'hojasTerapiaIV.solucion' 
        );
        $estancia = $hojasenfermeria->formularioInstancia->estancia;
        $paciente = $hojasenfermeria->formularioInstancia->estancia->paciente;

        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $soluciones = ProductoServicio::where('subtipo','INSUMOS')->get();  

        $columnasGraficas = [
            'fecha_hora_registro',
            'tension_arterial_sistolica',
            'tension_arterial_diastolica',
            'frecuencia_cardiaca',
            'frecuencia_respiratoria',
            'temperatura',
            'saturacion_oxigeno', 
            'glucemia_capilar',
            'talla',
            'peso',
        ];

        $dataParaGraficas = HojaSignos::select($columnasGraficas)
            ->where('hoja_enfermeria_id', $hojasenfermeria->id)
            ->orderBy('fecha_hora_registro', 'asc')
            ->get();

        return Inertia::render('formularios/hojas-enfermerias/edit',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'hojaenfermeria' => $hojasenfermeria, 
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones,
            'dataParaGraficas' => $dataParaGraficas,
        ]);
    }

    public function update(HojaEnfermeria $hojaenfermeria)
    {

    }
}
