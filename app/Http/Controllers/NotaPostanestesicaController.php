<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaPostanestesicaRequest;
use App\Models\Estancia;
use App\Models\Paciente;
use App\Models\FormularioInstancia;
use App\Models\FormularioCatalogo;
use App\Models\NotaPostanestesica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;

use Inertia\Inertia;

class NotaPostanestesicaController extends Controller
{

    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/nota-postanestesica/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(NotaPostanestesicaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_POSTANESTESICA,
                'user_id' => Auth::id(),
            ]);

            NotaPostanestesica::create([
                'id' => $formulario->id,
                ...$validatedData
            ]);

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota postanestesica.');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear hoja frontal: ' . $e->getMessage());
            return Redirect::back()->with('error','No se pudo crear la nota postanestésica: ' . $e->getMessage());
        }
    }

    public function generarPDF(NotaPostanestesica $notaspostanestesica)
    {
        $notaspostanestesica->load(
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
        );

        $paciente = $notaspostanestesica->formularioInstancia->estancia->paciente;
        $medico = $notaspostanestesica->formularioInstancia->user;
        $estancia = $notaspostanestesica->formularioInstancia->estancia;

        $headerData = [
            'historiaclinica' => $notaspostanestesica,
            'paciente' => $paciente,
            'estancia' => $estancia, 
        ];

        $viewData = [
            'notaData' => $notaspostanestesica,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-postanestesica',
            $viewData,
            $headerData,
            'nota-postanestesica-',
            $estancia->folio
        );
    }
}
