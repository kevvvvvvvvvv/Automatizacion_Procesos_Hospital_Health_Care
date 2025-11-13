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
use Spatie\LaravelPdf\Facades\Pdf; 

use App\Http\Requests\NotaUrgenciaRequest;
use Redirect;

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
    // Agrega esto para ver si llega aquí y qué datos recibe
    \Log::info('Datos validados:', $request->validated());
    
    $validatedData = $request->validated();
    
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
       
        \Log::info('NotaUrgencia creada:', $notaUrgencia->toArray());
        
        DB::commit();
        return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota nota urgencia'); 
    } catch (\Exception $e) {
        
        \Log::info('NotaUrgencia no creada', $notaUrgencia->toArray());
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error al crear la nota de urgencia: ' . $e->getMessage()])->withInput();
    }
}

    public function show(Paciente $paciente, Estancia $estancia, NotaUrgencia $notasurgencia)  
   {
       $notasurgencia->load('formularioInstancia.user', 'formularioInstancia.estancia.paciente');
       
       return Inertia::render('formularios/notaurgencia/show', [
           'notaUrgencia' => $notasurgencia,  
           'paciente' => $paciente,
           'estancia' => $estancia,
       ]);
   }

    public function edit(Paciente $paciente, Estancia $estancia, NotaUrgencia $notasurgencia)
{
    $notasurgencia->load('formularioInstancia.user', 'formularioInstancia.estancia.paciente');
    
    return Inertia::render('formularios/notaurgencia/edit', [
        'paciente' => $paciente,
        'estancia' => $estancia,
        'notaUrgencia' => $notasurgencia,
    ]);
}

public function update(NotaUrgenciaRequest $request, Paciente $paciente, Estancia $estancia, NotaUrgencia $notasurgencia)
{
    $validatedData = $request->validated();
    
    DB::beginTransaction();
    try {
        $notasurgencia->update($validatedData);
        
        DB::commit();
        return Redirect::route('notasurgencias.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'notasurgencia' => $notasurgencia->id,
        ])->with('success', 'Nota de urgencia actualizada exitosamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => 'Error al actualizar la nota de urgencia: ' . $e->getMessage()])->withInput();
    }
}
    public function generarPDF(NotaUrgencia $notasurgencia)
    {
        // Carga las relaciones necesarias
        $notasurgencia->load('formularioInstancia.user', 'formularioInstancia.estancia.paciente');
        
        // Prepara los datos para el PDF
        $notaData = [
            'motivo_de_la_atencion_o_interconsulta' => $notasurgencia->motivo_atencion,
            'resumen_del_interrogatorio' => $notasurgencia->resumen_interrogatorio,
            'exploracion_fisica' => $notasurgencia->exploracion_fisica,
            'ta' => $notasurgencia->ta,
            'fc' => $notasurgencia->fc,
            'fr' => $notasurgencia->fr,
            'temp' => $notasurgencia->temp,
            'peso' => $notasurgencia->peso,
            'talla' => $notasurgencia->talla,
            'estado_mental' => $notasurgencia->estado_mental,
            'resultados_relevantes_del_estudio_diagnostico' => $notasurgencia->resultados_relevantes,
            'diagnostico_o_problemas_clinicos' => $notasurgencia->diagnostico_problemas_clinicos,
            'tratamiento_y_pronostico' => $notasurgencia->tratamiento . ' | Pronóstico: ' . $notasurgencia->pronostico,
        ];
        
        // Obtén el médico (usuario que creó la instancia)
        $medico = $notasurgencia->formularioInstancia->user ?? null;
        
        // Genera el PDF usando la API de Spatie
        $pdf = Pdf::view('pdf.notaurgencia', compact('notaData', 'medico'));
        
        // Descarga el PDF
        return $pdf->download('nota_urgencia_' . $notasurgencia->id . '.pdf');
    }
}