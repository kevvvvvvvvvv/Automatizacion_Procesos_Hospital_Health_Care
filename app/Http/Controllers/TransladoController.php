<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translado;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

// use Illuminate\Http\Request;

class TransladoController extends Controller
{
    //
    public function index()
    {
        //
    }

    public function create(Paciente $paciente, Estancia $estancia)     
    {
        return Inertia::render('formularios/traslado/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'unidad_medica_envia' => 'required|string|max:255',
            'unidad_medica_recibe' => 'required|string|max:255',
            'motivo_translado' => 'required|string',
            'Resumen_clinico' => 'required|string',
            'ta' => 'nullable|string|max:50',
            'fc' => 'nullable|string|max:50',
            'fr' => 'nullable|string|max:50',
            'sat' => 'nullable|string|max:50',
            'temp' => 'nullable|string|max:50',
            'dxtx' => 'nullable|string|max:255',
            'tratamiento_terapeutico_administrada' => 'nullable|string',
        ]);
        DB::beginTransaction();
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $request->estancia_id,
            'formulario_catalogo_id' => Translado::CATALOGO_ID,
            'user_id' => Auth::id(),
        ]);
        Translado::create([
            'id' => $formularioInstancia->id,
            ...$validatedData
        ]);
        DB::commit();
        return redirect()->route('pacientes.estancias.show', [
            'paciente' => $request->paciente_id,
            'estancia' => $request->estancia_id,
        ])->with('success', 'Translado creado exitosamente.');
    }


    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
