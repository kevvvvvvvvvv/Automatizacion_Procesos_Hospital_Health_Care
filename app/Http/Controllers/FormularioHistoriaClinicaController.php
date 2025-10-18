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
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;

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

        // Log para verificar el ID del formulario creado
        Log::info('FormularioInstancia creado con ID: ' . ($formulario ? $formulario->id : 'FALLÓ'));
        if (!$formulario || !$formulario->id) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error crítico al crear la instancia del formulario.');
        }

        // Usa firstOrCreate para manejar el caso de que ya exista (aunque la lógica indica que no debería)
        $historiaClinica = HistoriaClinica::firstOrCreate(
            ['id' => $formulario->id], // Busca por este ID
            [ // Datos para crear si no existe
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
            ]
        );

        // Log para verificar el ID de la historia clínica
        Log::info('HistoriaClinica obtenida/creada con ID: ' . ($historiaClinica ? $historiaClinica->id : 'FALLÓ'));
        if (!$historiaClinica || !$historiaClinica->id) {
            DB::rollBack();
            Log::error('Fallo al crear/obtener HistoriaClinica para Formulario ID: ' . $formulario->id);
            return redirect()->back()->with('error', 'Error crítico al crear/obtener la historia clínica.');
        }

        // Asegúrate de que $historiaClinica->id sea el correcto antes del bucle
        $hcId = $historiaClinica->id;
        Log::info('ID a usar para RespuestaFormulario: ' . $hcId);


        foreach ($validatedData['respuestas'] as $preguntaId => $detalles) {
            if (!empty($detalles['respuesta']) || !empty($detalles['campos']) || !empty($detalles['items'])) {
                Log::info("Intentando crear Respuesta para HC ID: {$hcId}, Pregunta ID: {$preguntaId}");
                RespuestaFormulario::create([
                    'historia_clinica_id'   => $hcId, // Usa la variable verificada
                    'catalogo_pregunta_id'  => $preguntaId,
                    'detalles'              => $detalles,
                ]);
            }
        }
        
        DB::commit();

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error en store HistoriaClinica: ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine()); // Log más detallado
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
        $historiaclinica->load([
            'formularioInstancia.estancia',
            'respuestaFormularios'
        ]);

        $paciente = $historiaclinica->formularioInstancia->estancia->paciente;

        $preguntasPorCategoria = CatalogoPregunta::where('formulario_catalogo_id', 2) 
                                         ->orderBy('orden')
                                         ->get()
                                         ->groupBy('categoria');

        $respuestasMap = $historiaclinica->respuestaFormularios->keyBy('catalogo_pregunta_id');

        //dd($respuestasMap);

        return Pdf::view('pdfs.historia-clinica', [
            'historiaclinica' => $historiaclinica,
            'paciente' => $paciente,
            'preguntasPorCategoria' => $preguntasPorCategoria, 
            'respuestasMap' => $respuestasMap,
        ])->inline('hoja-frontal.pdf');
    }

}
