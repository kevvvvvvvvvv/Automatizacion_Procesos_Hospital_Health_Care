<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estancia;
use App\Models\Consentimiento;
use App\Models\Paciente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;
use App\Http\Requests\consentimientoRequest;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;



class ConsentimientoController extends Controller


{
    protected PdfGeneratorService $pdfGenerator;

        public function __construct(PdfGeneratorService $pdfGenerator)
        {
            $this->pdfGenerator = $pdfGenerator;
        }

    
        public function boot()
        {
            Carbon::setLocale('es');
        }
    public function create(Paciente $paciente, Estancia $estancia, consentimientoRequest $request)
    {

        return Inertia::render('consentimiento/create', ['paciente'=>$paciente,  'estancia'=>$estancia]);
    }
   
    public function store(Paciente $paciente, Estancia $estancia, Request $request)
    {
        $validated = $request->validate([
            'route_pdf' => ['required', 'array', 'min:1'],
            'route_pdf.*' => ['string'],
            'diagnostico' => ['nullable', 'string'],
        ]);


        $map = [
            '0' => 'Consentimiento_informado_hospitalizacion',
            '1' => 'Consentimiento_cirugia_mayor',
            '2' => 'Consentimiento_informado_bajo_informacion_anestesico',
            '3' => 'Consentimiento_Salpingoclasia_vasectomia',
            '4' => 'Consentimiento_organos_tejidos_trasplantes',
            '5' => 'Consentimiento_investigacion',
            '6' => 'Consentimiento_necropsia_hospitalaria',
            '7' => 'Consentimiento_diagnostico_terapeutico',
            '8' => 'Consentimiento_mutilacion',
            '9' => 'Consentimiento_transfusion_sanguinea',
            '10' => 'consentimiento_reanimacion',
        ];

        $diagnostico = $validated['diagnostico'] ?? null;
        $selections = $validated['route_pdf'];

        DB::beginTransaction();

        try {
            foreach ($selections as $key) {

                if (!isset($map[$key])) {
                    continue; 
                }

                $bladeName = $map[$key];

            $route = "pdfs.consentimientos.{$bladeName}";

                Consentimiento::create([
                    'estancia_id' => $estancia->id,
                    'user_id' => Auth::id(),
                    'diagnostico' => $key === '10' ? $diagnostico : null,
                    'route_pdf' => $route,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('estancias.show', $estancia->id)
                ->with('success', 'Consentimientos guardados correctamente.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

public function generarPDF(string $file, Request $request, Paciente $paciente, Estancia $estancia, Consentimiento $consentimiento)
{   
    // 1. Lógica de datos (igual que tenías, pero limpia)
    $viewData = ['user' => Auth::user()];

    if ($request->has('consentimiento_id')) {
        $consentimientoId = intval($request->query('consentimiento_id'));
        $consentimiento = Consentimiento::with('estancia.paciente', 'user.credenciales')->find($consentimientoId);

        if (! $consentimiento) abort(404, "Consentimiento no encontrado.");
           $fecha = $consentimiento->created_at;
            // Extraer partes
            $meses = [
                1 => 'enero',
                2 => 'febrero',
                3 => 'marzo',
                4 => 'abril',
                5 => 'mayo',
                6 => 'junio',
                7 => 'julio',
                8 => 'agosto',
                9 => 'septiembre',
                10 => 'octubre',
                11 => 'noviembre',
                12 => 'diciembre',
            ];
            
            $dia = $fecha->day;
            $mes = $meses[$fecha->month];
            $anio = $fecha->year;
            $viewData = [
            'notaData' => $consentimiento,
            'paciente' => $consentimiento->estancia?->paciente,
            'medico' => $consentimiento->user,

            'fecha' => [
                'dia' => $dia,
                'mes' => $mes,
                'anio' => $anio,
            ],
        ];
    } else {
        
        $consentimiento->load('estancia', 'user.credenciales');
        $viewData = [
            'notaData' => $consentimiento, 
            'user' => Auth::user()
        ];
    }

$imagePath = public_path(' ');// images/Logo_HC_2.png
$logo = null; // Inicializa por si no existe la imagen

if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageMime = mime_content_type($imagePath);

    // Crear el Data URI correcto
    $logo = 'data:' . $imageMime . ';base64,' . $imageData;
}
     

        // Enviar al header
        $headerData = [
            'logoDataUri' => $logo,
            'notaData' => $consentimiento,
            'paciente' => $consentimiento->estancia?->paciente,
            'medico' => $consentimiento->user,
            'estancia'=> $consentimiento->estancia
        ];


    return Pdf::view($consentimiento->route_pdf, $viewData)

        ->format('Letter') // Formato carta
        ->name('consentimiento-' . ($consentimiento->estancia->folio ?? 'SN') . '.pdf')
        ->withBrowsershot(function (Browsershot $browsershot) {
            
            $this->configureBrowsershot($browsershot);
             
        })

        ->headerView('headerConsentimiento', $headerData)

        ->inline(); 
}
protected function configureBrowsershot(Browsershot $browsershot)
{
    $chromePath = config('services.browsershot.chrome_path');
    if ($chromePath) {
        $browsershot->setChromePath($chromePath);
        $browsershot->noSandbox();
        $browsershot->addChromiumArguments([
            'disable-dev-shm-usage',
            'disable-gpu',
        ]);
    }
}


}
