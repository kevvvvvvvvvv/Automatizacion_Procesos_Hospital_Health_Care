<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Preoperatoria;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\PreoperatoriaRequest;

class PreoperatoriaController extends Controller
{
    public function index()
    {
        //
    }
    public function create(paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/preoperatoria/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(PreoperatoriaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),  
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => 7, 
            'user_id' => Auth::id(),
        ]);
        $preoperatoria = Preoperatoria::create([
            'id' => $formularioInstancia->id,
            ...$validatedData
        ]);
        //dd($preoperatoria->toArray());
        DB::commit();
        return redirect()->route('estancias.show', [
            'estancia' => $estancia->id,
        ])->with('success', 'Preoperatoria creada exitosamente.');
    }
    public function show(Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        ]);
        return Inertia::render('formularios/preoperatoria/show', [
            'preoperatoria' => $preoperatoria,  // Aquí es 'preoperatoria' (con "a")
            'paciente'      => $preoperatoria->formularioInstancia->estancia->paciente,
            'estancia'      => $preoperatoria->formularioInstancia->estancia,
        ]);

    }
    public function edit(Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        ]);
        return Inertia::render('formularios/preoperatoria/edit', [
            'paciente' => $preoperatoria->formularioInstancia->estancia->paciente,
            'estancia' => $preoperatoria->formularioInstancia->estancia,
            'preoperatoria' => $preoperatoria,
        ]);
    }
    public function update(PreoperatoriaRequest $request, Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {
        $validatedData = $request->validated();
        $preoperatoria->update($validatedData);
        return redirect()->route('estancias.show', [
            'estancia' => $estancia->id,
        ])->with('success', 'Preoperatoria actualizada exitosamente.');
    }
    public function destroy($id)
    {
        //
    }
    public function generarPDF(Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        ]);

        $pdf = Pdf::loadView('pdfs.preoperatoria', [
            'preoperatoria' => $preoperatoria,
            'paciente' => $preoperatoria->formularioInstancia->estancia->paciente,
            'estancia' => $preoperatoria->formularioInstancia->estancia,
        ]);

        return $pdf->download('preoperatoria_' . $paciente->nombre . '_' . now()->format('Ymd_His') . '.pdf');
    }
}
