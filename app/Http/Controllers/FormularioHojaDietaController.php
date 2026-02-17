<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaDietaRequest;
use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\NuevaSolicitudDietas;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Dieta;
use App\Models\Estancia;

use App\Models\SolicitudDieta;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FormularioHojaDietaController extends Controller
{

    public function index()
    {
        $dietas = SolicitudDieta::with(['hojaEnfermeria.formularioInstancia.estancia.paciente'])
            ->where('estado', 'PENDIENTE')
            ->get(); 

        $agrupadasPorEstancia = $dietas->groupBy(function($dieta) {
            return $dieta->hojaEnfermeria->formularioInstancia->estancia_id;
        });


        return Inertia::render('cocina/index', [
            'solicitud_dietas' => $agrupadasPorEstancia 
        ]);
    }

    public function store(HojaDietaRequest $request, HojaEnfermeria $hojasenfermeria){
        
        $validatedData = $request->validated();
        
        try{

            $dieta = SolicitudDieta::create([
                ... $validatedData,
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'estado' => 'PENDIENTE',
                'horario_solicitud' => now(),
            ]);

            $this->enviarNotificacion($hojasenfermeria,$dieta);

            return Redirect::back()->with('success','Se ha enviado la solicitud de dieta');
        }catch(\Exception $e)
        {
            \Log::error('Error al crear la solicitd de dieta: '. $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitd de dieta.');
        }
    }

    public function show(Estancia $estancia){

        
        $dietas = SolicitudDieta::with(['hojaEnfermeria.formularioInstancia.estancia.paciente','dieta.categoriaDieta'])
            ->where('estado', 'PENDIENTE')
            ->whereHas('hojaEnfermeria.formularioInstancia.estancia', function ($query) use ($estancia) {
                $query->where('id', $estancia->id);
            })
            ->get();

        return Inertia::render('cocina/show',[
            'solicitud_dietas' => $dietas
        ]);
        
    }

    public function update(SolicitudDieta $solicitudes_dieta){
        try{
            

        }catch(\Exception $e){

        }
    }


    private function enviarNotificacion(HojaEnfermeria $hojasenfermeria, SolicitudDieta $dieta){

            $hojasenfermeria->load(
                'formularioInstancia.estancia.paciente'
            );

            $usuariosCocina = User::role('cocina')->get();

    
            Notification::send(
                $usuariosCocina, 
                new NuevaSolicitudDietas(
                    $dieta, 
                    $hojasenfermeria->formularioInstancia->estancia->paciente
                )
            );

    }
}
