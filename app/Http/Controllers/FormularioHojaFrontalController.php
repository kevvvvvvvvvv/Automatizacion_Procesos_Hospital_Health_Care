<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\FormularioCatalogo;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\HojaFrontal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaFrontalController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia){
        $medicos = User::all();

        return Inertia::render('formularios/hojas-frontales/create',[
                                'paciente' => $paciente,
                                'estancia' => $estancia,
                                'medicos' => $medicos,]);
    }

    public function store(Paciente $paciente, Estancia $estancia, Request $request){

        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => 1,
            'user_id' =>  auth::id(),
        ]);

        HojaFrontal::create([
            'id' => $formularioInstancia->id,
            'medico' =>  $request->medico,
            'medico_id' => $request->medico_id,
            'responsable' => $request->responsable,
            'notas' => $request->notas
        ]);

        $estancia->load(['paciente', 'creator', 'updater']);

        return Inertia::render('estancias/show', [
            'estancia' => $estancia,
            'paciente' => $estancia->paciente,
            'creator'  => $estancia->creator,
            'updater'  => $estancia->updater,
            'actualizador' => $estancia->updater,
        ]);
    }
}
