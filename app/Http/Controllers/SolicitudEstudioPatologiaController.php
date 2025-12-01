<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudPatologiaRequest;
use Illuminate\Http\Request;
use DB;
use Exception;
use Redirect;
use Auth;
use Log;

use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Models\SolicitudPatologia;
use App\Services\VentaService;
use App\Services\PdfGeneratorService;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class SolicitudEstudioPatologiaController extends Controller
{

    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator){
        return $this->pdfGenerator = $pdfGenerator;
    }

    public function store(SolicitudPatologiaRequest $request, Estancia $estancia)
    {
        DB::beginTransaction();
        try{
            $validatedData = $request->validated();

            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_PATOLOGIA,
                'user_id' =>  Auth::id(),
            ]);

            SolicitudPatologia::create([
                ...$validatedData,
                'id' => $formularioInstancia->id,
                'fecha_estudio' => now(),
            ]);

            DB::commit();
            return Redirect::back()->with('success','Se ha creado la solicitud de estudio anatomopatológico');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear la solicitud de estudio anatomopatológico');
            return Redirect::back()->with('error','Error al crear la solicitud de estudio anatomopatológico: ' . $e->getMessage());    
        }
    }

    public function generarPDF(SolicitudPatologia $solicitudespatologia)
    {
        $solicitudespatologia->load(
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user.credenciales',
        );

        $paciente = $solicitudespatologia->formularioInstancia->estancia->paciente;
        $medico = $solicitudespatologia->formularioInstancia->user;
        $estancia = $solicitudespatologia->formularioInstancia->estancia;

        $headerData = [
            'historiasclinicas' => $solicitudespatologia,
            'estancia' => $estancia,
            'paciente' => $paciente,
        ];

        $viewData = [
            'notaData' => $solicitudespatologia,
            'paciente' => $paciente,
            'meidco' => $medico,
        ];

        Pdf::view('pdfs.solicitud-patologia', [
            'notaData' => $solicitudespatologia,
            'estancia' => $estancia,
            'paciente' => $paciente,
            'medico'  => $medico
        ]
        )->withBrowsershot(function (Browsershot $browsershot) {
            $chromePath = config('services.browsershot.chrome_path');
            if ($chromePath) {
                $browsershot->setChromePath($chromePath);
                $browsershot->noSandbox();
                $browsershot->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                ]);
            }
            })
        ->headerView('header', $headerData) 
        ->inline('envio-pieza-patologica- ' . $estancia->folio . '.pdf');

    }
}
