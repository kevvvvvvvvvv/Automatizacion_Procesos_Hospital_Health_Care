<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dieta\UpdateHojaDietaRequest;
use App\Http\Requests\HojaDietaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\NuevaSolicitudDietas;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

use App\Models\Formulario\HojaEnfermeria\SolicitudDieta;
use App\Models\User;
use App\Models\Estancia;
use App\Models\Formulario\HojaEnfermeria\HojaEnfermeria;

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
            ->whereHas('hojaEnfermeria.formularioInstancia.estancia', function ($query) use ($estancia) {
                $query->where('id', $estancia->id);
            })
            ->get();
        $users = User::all();

        return Inertia::render('cocina/show',[
            'solicitud_dietas' => $dietas,
            'users' => $users, 
        ]);
        
    }

    public function update(UpdateHojaDietaRequest $request, SolicitudDieta $solicitud_dieta){
        
        $validatedData = $request->validated();

        try{
            $solicitud_dieta->update([
                'estado' => 'SURTIDA',
                'user_entrega_id' => Auth::id(),
                'horario_entrega' => now(),
                'user_supervisa_id' => $validatedData['user_supervisa_id'],
            ]);

            return Redirect::back()->with('success','Se ha marcado la hora de entrega.');
        }catch(\Exception $e){
            \Log::error('Error al marcar la hora de entrega');
            return Redirect::back()->with('error','Error al marcar la hora de entrega.');
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
