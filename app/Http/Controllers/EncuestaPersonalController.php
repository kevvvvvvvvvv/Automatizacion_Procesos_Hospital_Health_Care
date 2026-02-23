<?php

namespace App\Http\Controllers;

use App\Models\EncuestaPersonal;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Http\Requests\PersonalRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EncuestaPersonalController extends Controller
{
    public function create(Estancia $estancia)
    {   
        /*$encuesta_personal->load(['formularioInstancia.user', 
            'formularioInstancia.estancia.paciente'
        ]);*/
        $estancia->load('paciente');
        //dd($estancia);
        return Inertia::render('formularios/encuestas-personal/create', [
            'estancia' => $estancia,
            
        ]);
    }

    public function store(PersonalRequest $request, Estancia $estancia)
{
    $validatedData = $request->validated();
    
    try {
        DB::beginTransaction();
        
        // Creamos la instancia principal
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_ENCUESTA_PERSONAL,
            'user_id' => Auth::id(),
        ]);

        // Creamos la encuesta usando el mismo ID
        // Esto fallará si 'id' no está en el fillable del modelo arriba
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
        // Agregamos dd($e->getMessage()) aquí si quieres ver el error exacto en pantalla
        return back()->withErrors(['error' => 'Error: ' . $e->getMessage()]);
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