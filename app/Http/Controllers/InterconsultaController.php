<?php

namespace App\Http\Controllers;
use App\Models\Interconsulta;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InterconsultasRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

use Illuminate\Http\Request;

class InterconsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Paciente $paciente, Estancia $estancia)
     {
        return Inertia::render('formularios/interconsulta/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
     }

    /**
     * @param  \Illuminate\Http\Request
     * @param \App\Models\Interconsulta
     * @param \App\Models\Estancia
     * 
     */
   public function store(InterconsultasRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();
        DB::beginTransaction();
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => 3,
            'user_id' => Auth::id(),
        ]);
        // Asigna el resultado a $interconsulta
        $interconsulta = Interconsulta::create([
            'id' => $formularioInstancia->id,
            ...$validatedData
        ]);
        DB::commit();
        return Inertia::render('paciente.estancia.show', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'interconsulta' => $interconsulta,
        ]);
    }
     

    /**
     * Display the specified resource.
     */
     public function show(Paciente $paciente, Estancia $estancia, Interconsulta $interconsulta)
        {
            $interconsulta->load([
                'formularioInstancia.estancia.paciente',
                'formularioInstancia.user',
                'honorarios'
            ]);
            // dd($interconsulta->toArray());
            return Inertia::render('formularios/interconsulta/show', [
                'interconsulta' => $interconsulta,
                'paciente' => $interconsulta->formularioInstancia->estancia->paciente,
                'estancia' => $interconsulta->formularioInstancia->estancia,
                'honorarios' => $interconsulta->honorarios,
                'honorarios_total' => $interconsulta->honorarios->sum('monto'),
            ]);
        }
    /**
     * Show the form for editing the specified interconsulta.
     */
    public function edit(Interconsulta $interconsulta)
    {
        $interconsulta->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user'
        ]);
        return Inertia::render('formularios/interconsulta/edit', [
            'interconsulta' => $interconsulta,
            'paciente' => $interconsulta->formularioInstancia->estancia->paciente,
            'estancia' => $interconsulta->formularioInstancia->estancia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interconsulta $interconsulta)
    {
        $validatedData = $request->validate([
            'ta' => 'string',
            'fc' => 'integer|min:0',
            'fr' => 'integer|min:0',
            'temp' => 'numeric|min:20',
            'peso' => 'numeric|min:0',
            'talla' => 'numeric|min:0',
            'criterio_diagnostico' => 'string',
            'plan_de_estudio' => 'string',
            'sugerencia_diagnostica' => 'string',
            'resumen_del_interrogatorio' => 'string',
            'exploracion_fisica' => 'string',
            'estado_mental' => 'string',
            'resultados_relevantes_del_estudio_diagnostico' => 'string',
            'tratamiento_y_pronostico' => 'string',
            'motivo_de_la_atencion_o_interconsulta' => 'required|string',
            'diagnostico_o_problemas_clinicos' => 'required|string',
        ]);

        $interconsulta->update($validatedData);

        return redirect()->route('interconsultas.show', ['interconsulta' => $interconsulta->id])
            ->with('success', 'Interconsulta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generarPDF(Interconsulta $interconsulta)
    {
        $interconsulta->load([
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales'
        ]);
        $paciente = $interconsulta->formularioInstancia->estancia->paciente;
        $medico = $interconsulta->formularioInstancia->user;
        $estancia = $interconsulta->formularioInstancia->estancia;

        $logoDataUri = '';
        $imagePath = public_path('images/Logo_HC_2.png');
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            $logoDataUri = 'data:' . $imageMime . ';base64,' . $imageData;
        }

        $headerData = [
            'historiaclinica' => $interconsulta,
            'paciente' => $paciente,
            'logoDataUri' => $logoDataUri,
            'estancia' => $estancia
        ];

        return Pdf::view('pdfs.interconsultas', [
            'notaData' => $interconsulta,
            'paciente' => $paciente,
            'medico' => $medico
        ])
        ->headerView('header', $headerData)
        ->inline('interconsultas.pdf');
    }
}
