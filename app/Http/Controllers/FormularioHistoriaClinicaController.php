<?php

namespace App\Http\Controllers;

use App\Http\Requests\HistoriaClinicaRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CatalogoPregunta;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\HistoriaClinica;
use App\Models\RespuestaFormulario;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\Auth;

class FormularioHistoriaClinicaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        $preguntas = CatalogoPregunta::where('formulario_catalogo_id', 2)
                                      ->orderBy('orden')
                                      ->get();

        return Inertia::render('formularios/historias-clinicas/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'preguntas' => $preguntas,
        ]);
    }

/**
     * Guarda una nueva historia clínica en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @param  \App\Models\Estancia  $estancia
     * @return \Illuminate\Http\RedirectResponse
     */
   public function store(HistoriaClinicaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => 2,
                'user_id' => Auth::id(),
            ]);

            $historiaClinica = HistoriaClinica::create([
                'id'                        => $formulario->id, 
                'padecimiento_actual'       => $validatedData['padecimiento_actual'],
                'tension_arterial'          => $validatedData['tension_arterial'],
                'frecuencia_cardiaca'       => $validatedData['frecuencia_cardiaca'],
                'frecuencia_respiratoria'   => $validatedData['frecuencia_respiratoria'],
                'temperatura'               => $validatedData['temperatura'],
                'peso'                      => $validatedData['peso'],
                'talla'                     => $validatedData['talla'],
                'resultados_previos'        => $validatedData['resultados_previos'],
                'diagnostico'               => $validatedData['diagnostico'],
                'pronostico'                => $validatedData['pronostico'],
                'indicacion_terapeutica'    => $validatedData['indicacion_terapeutica'],
            ]);

            foreach ($validatedData['respuestas'] as $preguntaId => $detalles) {
                if (!empty($detalles['respuesta']) || !empty($detalles['campos']) || !empty($detalles['items'])) {
                    RespuestaFormulario::create([
                        'historia_clinica_id'   => $historiaClinica->id,
                        'catalogo_pregunta_id'  => $preguntaId,
                        'detalles'              => $detalles, 
                    ]);
                }
            }
            
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Error Detallado: ' . $e->getMessage());
        }

        return redirect()->route('estancias.show', ['estancia' => $estancia->id])
                        ->with('success', 'Historia Clínica registrada exitosamente.');
    }

    public function edit(){

    }

    public function update(){
        
    }

    public function generarPDF(HistoriaClinica $historiaclinica)
    {
        $historiaclinica->load('formularioInstancia.estancia.paciente');
    }

}
