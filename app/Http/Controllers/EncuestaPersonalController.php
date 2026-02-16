<?php

namespace App\Http\Controllers;

use App\Models\EncuestaPersonal;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use Illuminate\Http\Request;
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

    public function store(Request $request, Estancia $estancia)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'trato_claro' => 'required|numeric|min:1|max:5',
            'presentacion_personal' => 'required|numeric|min:1|max:5',
            'tiempo_atencion' => 'required|numeric|min:1|max:5',
            'informacion_tratamiento' => 'required|numeric|min:1|max:5',
            'comentarios' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // 2. Crear el registro
            EncuestaPersonal::create([
                'estancia_id' => $estancia->id,
                'trato_claro' => $validated['trato_claro'],
                'presentacion_personal' => $validated['presentacion_personal'],
                'tiempo_atencion' => $validated['tiempo_atencion'],
                'informacion_tratamiento' => $validated['informacion_tratamiento'],
                'comentarios' => $validated['comentarios'],
                'usuario_id' => auth()->id(), // El ID del usuario logueado
            ]);

            DB::commit();

            // 3. Redirigir a la vista de la estancia con éxito
            return redirect()->route('estancias.show', $estancia->id)
                ->with('message', 'Encuesta guardada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error al guardar la encuesta: ' . $e->getMessage()]);
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