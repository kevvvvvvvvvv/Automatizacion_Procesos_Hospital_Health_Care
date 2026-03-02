<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use App\Models\Encuestas\EncuestaPersonal;
use App\Models\Estancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;

class EncuestaPersonalController extends Controller
{
    public function create(Estancia $estancia)
    {   
        $estancia->load('paciente');

        return Inertia::render('formularios/encuestas-personal/create', [
            'estancia' => $estancia,
            
        ]);
    }

    public function store(PersonalRequest $request, Estancia $estancia)
{
    $validatedData = $request->validated();
    
    try {
        DB::beginTransaction();
        
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_ENCUESTA_PERSONAL,
            'user_id' => Auth::id(),
        ]);

        EncuestaPersonal::create([
            'id' => $formularioInstancia->id,
            'trato_claro' => $validatedData['trato_claro'],
            'presentacion_personal' => $validatedData['presentacion_personal'],
            'tiempo_atencion' => $validatedData['tiempo_atencion'],
            'informacion_tratamiento' => $validatedData['informacion_tratamiento'],
            'comentarios' => $validatedData['comentarios'] ?? null,
        ]);

        DB::commit();

        return redirect()->route('estancias.show', $estancia->id)
            ->with('message', 'Encuesta guardada correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error al registrar la encuesta.' . $e->getMessage());
        return back()->withErrors(['error' => 'Error al registrar la encuesta']);
    }
}
    public function show(){

    }
    public function update(){

    }
    public function edit(){

    }
    public function generarPDF(){
        
    }
}