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
use Illuminate\Support\Facades\Redirect;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class FormularioHistoriaClinicaController extends Controller
{
    public function show()
    {
        return Redirect::back()->with('error','La opción de mostrar no esta habilitada por el momento.');
    }

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

            if (!$formulario || !$formulario->id) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Error crítico al crear la instancia del formulario.');
            }

            $historiaClinica = HistoriaClinica::firstOrCreate(
                ['id' => $formulario->id], 
                [ 
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
            if (!$historiaClinica || !$historiaClinica->id) {
                DB::rollBack();
                Log::error('Fallo al crear/obtener HistoriaClinica para Formulario ID: ' . $formulario->id);
                return redirect()->back()->with('error', 'Error crítico al crear/obtener la historia clínica.');
            }

            $hcId = $historiaClinica->id;

            foreach ($validatedData['respuestas'] as $preguntaId => $detalles) {
                if (!empty($detalles['respuesta']) || !empty($detalles['campos']) || !empty($detalles['items'])) {
                    RespuestaFormulario::create([
                        'historia_clinica_id'   => $hcId, 
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
        return Redirect::back()->with('error','La opción de editar no esta habilitada por el momento.');
    }

    public function update(){
        
    }

    public function generarPDF(HistoriaClinica $historiaclinica)
    {
        $historiaclinica->load([
            'formularioInstancia.estancia',
            'respuestaFormularios',
            'formularioInstancia.user.credenciales'
        ]);

        $paciente = $historiaclinica->formularioInstancia->estancia->paciente;
        $medico = $historiaclinica->formularioInstancia->user;
        $estancia = $historiaclinica->formularioInstancia->estancia;

        $preguntasPorCategoria = CatalogoPregunta::where('formulario_catalogo_id', 2) 
                                         ->orderBy('orden')
                                         ->get()
                                         ->groupBy('categoria');

        $respuestasMap = $historiaclinica->respuestaFormularios->keyBy('catalogo_pregunta_id');

        $logoDataUri = '';
        $imagePath = public_path('images/Logo_HC_2.png');
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            $logoDataUri = 'data:' . $imageMime . ';base64,' . $imageData;
        }

        $headerData = [
            'historiaclinica' => $historiaclinica,
            'paciente' => $paciente,
            'logoDataUri' => $logoDataUri,
            'estancia' => $estancia
        ];

        return Pdf::view('pdfs.historia-clinica', [
            'historiaclinica' => $historiaclinica,
            'paciente' => $paciente,
            'preguntasPorCategoria' => $preguntasPorCategoria, 
            'respuestasMap' => $respuestasMap,
            'medico' => $medico
        ])
        ->withBrowsershot(function (Browsershot $browsershot){
            $chromePath = config('services.browsershot.chrome_path');
            if ($chromePath) {
                $browsershot->setChromePath($chromePath);
                $browsershot->noSandbox();
                $browsershot->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                ]);
            } else {

            }
        })
        ->headerView('header', $headerData)
        ->inline('hoja-frontal.pdf');
    }

}
