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
use Spatie\LaravelPdf\Facades\Pdf;

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

        $estancia->load(['paciente', 'creator', 'updater','formularioInstancias.catalogo','formularioInstancias.user']);

        return Inertia::render('estancias/show', [
            'estancia' => $estancia,
        ]);
    }

    public function generarPDF(HojaFrontal $hojafrontal)
    {
        $hojafrontal->load('formularioInstancia.estancia.paciente','formularioInstancia.estancia.familiarResponsable');
        $estancia = $hojafrontal->formularioInstancia->estancia;
        $paciente = $estancia->paciente;
        $familiar_responsable = $hojafrontal->formularioInstancia->estancia->familiarResponsable;

        return Pdf::view('pdfs.hoja_frontal', [
            'hojafrontal' => $hojafrontal,
            'estancia'    => $estancia,
            'paciente'    => $paciente,
            'familiar_responsable' => $familiar_responsable,
        ])->inline('hoja-frontal-' . $paciente->id . '.pdf');
    }

}
