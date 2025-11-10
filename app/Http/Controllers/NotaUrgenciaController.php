<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotaUrgencia;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\NotaUrgenciaRequest;

class NotaUrgenciaController extends Controller
{
    public function index()
    {
        //
    }
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/notaurgencia/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(Paciente $paciente, Estancia $estancia, NotaUrgenciaRequest $request)
    {
        $validatedData = $request->validate();
        DB::beginTransaction();
        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => NotaUrgencia::CATALOGO_ID, 
                'user_id' => Auth::id(),
            ]);
            $notaUrgencia = NotaUrgencia::create([
                'id' => $formularioInstancia->id,
                ...$validatedData
            ]);
            dd($notaUrgencia);
            DB::commit();
            return redirect()->route('estancias.show', [
                'estancia' => $estancia->id,
            ])->with('success', 'Nota de urgencia creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Error al crear la nota de urgencia: ' . $e->getMessage()])->withInput();
        }
    }
    public function show()
    {
        //
    }
    public function edit()
    {
        //
    }
    public function update(Request $request)
    {
        //
    }
    public function destroy()
    {
        //
    }
}
