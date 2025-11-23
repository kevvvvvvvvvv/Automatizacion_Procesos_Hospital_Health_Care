<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\NotaEgreso;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\NotaEgresoRequest;



class NotasEgresoController extends Controller
{
    public function index(){
        //
    }
    public function create(paciente $paciente, Estancia $estancia){
        return Inertia::render('formularios/notaegreso/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(NotaEgresoRequest $request ,paciente $paciente, Estancia $estancia){
        $validateData = $request->validated();

        if ($validateData['motivo_egreso'] === 'otro') {
            $validateData['motivo_egreso'] = $validateData['motivo_egreso_otro'];
        }
        unset($validateData['motivo_egreso_otro']);

        DB::beginTransaction();
        try{
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => 11, 
                'user_id' => Auth::id(),
            ]);
            $notaEgreso = NotaEgreso::create([
                'id' => $formularioInstancia->id,
                ...$validateData
            ]);
            DB::commit();
                    
            return redirect()->route('pacientes.estancias.notasegresos.show', [
                'paciente' => $paciente->id,
                'estancia' => $estancia->id,
                'notaEgreso' => $notaEgreso->id,
            ])->with('success', 'Nota Egreso creada exitosamente.');
        } catch(\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear nota de egreso: ' . $e->getMessage()); 
        }
    }
    public function show(NotaEgreso $notasegreso, paciente $paciente, Estancia $estancia)
{
    $notasegreso->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');
    //dd($notasegreso->toArray());
    $paciente = $notasegreso->formularioInstancia->estancia->paciente;  // Resuelve desde la relación
    $estancia = $notasegreso->formularioInstancia->estancia;
    
    return Inertia::render('formularios/notaegreso/show', [
        'notaEgreso' => $notasegreso,
        'paciente'   => $paciente,
        'estancia'   => $estancia,
    ]);
}
    public function update(paciente $paciente, Estancia $estancia){

    }
    public function edit(paciente $paciente, Estancia $estancia){

    }
    public function generadPDF(Paciente $paciente, Estancia $estancia, NotaEgreso $notaEgreso) 
{
    $notaEgreso->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');
    
    $pdf = Pdf::loadView('pdf.notasEgresos', [ 
        'notaEgresos' => $notaEgreso,  
        'paciente' => $notaEgreso->formularioInstancia->estancia->paciente,  
        'estancia' => $notaEgreso->formularioInstancia->estancia,
    ]);
    
    return $pdf->download('nota_egreso.pdf');  
}
}