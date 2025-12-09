<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaEnfermeriaRequest;
use App\Models\CatalogoEstudio;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Models\HojaEnfermeria;
use App\Models\ProductoServicio;
use App\Models\HojaMedicamento;
use App\Models\HojaSignos;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Inertia\Inertia;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class FormularioHojaEnfermeriaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        $estancia->load('formularioInstancias.hojaEnfermeria');

        foreach ($estancia->formularioInstancias as $instancia) {
            if ($instancia->hojaEnfermeria && $instancia->hojaEnfermeria->estado == 'Abierto') {
                return Redirect::back()->with('error', 'Se tiene que cerrar la hoja de enfermería antes de crear una nueva');
            }
        }

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
                'formulario_catalogo_id' => FormularioCatalogo::ID_HOJA_ENFERMERIA,
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
            'hojasTerapiaIV.solucion',
            'hojaMedicamentos.productoServicio',
            'hojaMedicamentos.aplicaciones',
            'formularioInstancia.estancia.hojaOxigenos.userInicio',
            'formularioInstancia.estancia.hojaOxigenos.userFIn',  
        );
        $estancia = $hojasenfermeria->formularioInstancia->estancia;
        $estancia->load('hojaSondasCateters');

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
            'estado_conciencia',
            'peso',
        ];

        $catalogoEstudios = CatalogoEstudio::all();
        $solicitudesAnteriores = $estancia->formularioInstancias
                                ->map(fn($instancia) => $instancia->solicitudEstudio)
                                ->filter() 
                                ->sortByDesc('created_at')
                                ->values();
        
        $medicos = User::all();
        $usuarios = User::all();

        $dataParaGraficas = HojaSignos::select($columnasGraficas)
            ->where('hoja_enfermeria_id', $hojasenfermeria->id)
            ->orderBy('fecha_hora_registro', 'asc')
            ->get();


        $notaPostoperatoria = $estancia->notasPostoperatorias()->latest()->first();
        return Inertia::render('formularios/hojas-enfermerias/edit',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'hojaenfermeria' => $hojasenfermeria, 
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones,
            'dataParaGraficas' => $dataParaGraficas,
            'catalogoEstudios' => $catalogoEstudios,
            'solicitudesAnteriores' => $solicitudesAnteriores,
            'medicos' => $medicos,
            'usuarios' => $usuarios,
            'notaPostoperatoria' => $notaPostoperatoria,
        ]);
    }

    /**
     * Actualiza la hoja de enfermería (Observaciones o Estado).
     *
     * @param  \Illuminate\Http\Request  
     * @param  \App\Models\HojaEnfermeria  
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(HojaEnfermeriaRequest $request, HojaEnfermeria $hojasenfermeria)
    {
        if ($hojasenfermeria->estado === 'Cerrado' && !$request->has('estado')) {
             return Redirect::back()->with('error', 'Esta hoja ya está cerrada y no puede ser modificada.');
        }

        $hojasenfermeria->update($request->validated());
        
        $message = 'Hoja de enfermería actualizada.';

        if ($request->has('estado')) {
            $message = '¡Hoja de enfermería cerrada exitosamente!';
        }
        
        return Redirect::back()->with('success', $message);
    }
}
