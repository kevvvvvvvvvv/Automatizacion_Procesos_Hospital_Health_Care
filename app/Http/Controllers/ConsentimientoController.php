<?php

namespace App\Http\Controllers;

use App\Notifications\NuevoConsentimientoNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Log;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;
use App\Http\Requests\consentimientoRequest;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

use App\Model\FormularioInstancia;
use App\Models\Estancia;
use App\Models\Consentimiento;
use App\Models\Paciente;

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
            '11' => 'Indicaciones_hospitalario',
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
    if ($request->has('consentimiento_id')) {
        $consentimientoId = intval($request->query('consentimiento_id'));
        
        $consentimiento = Consentimiento::with([
            'user.credenciales', // <--- Importante
            'estancia.paciente',
            'estancia.familiarResponsable',
            'estancia.formularioInstancias.hojaFrontal.medico.credenciales'
        ])->find($consentimientoId);

        if (!$consentimiento) abort(404, "Consentimiento no encontrado.");

        $instanciaConFrontal = $consentimiento->estancia->formularioInstancias
            ->whereNotNull('hojaFrontal')
            ->first();
        $medicoFrontal = $instanciaConFrontal ? $instanciaConFrontal->hojaFrontal->medico : null;

        $fecha = $consentimiento->created_at;
        $meses = [1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 
                  7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'];
        
        // 2. Pasamos los datos a la vista. 
        // Si usas el médico que inició sesión o creó el registro:
        $medicoFirmante = $consentimiento->user; 

        $viewData = [
            'notaData' => $consentimiento,
            'paciente' => $consentimiento->estancia->paciente,
            'medico'   => $medicoFirmante, // Ahora este objeto tiene 'credenciales'
            'estancia' => $consentimiento->estancia->familiarResponsable,
            'fecha' => [
                'dia' => $fecha->day,
                'mes' => $meses[$fecha->month],
                'anio' => $fecha->year,
            ],
        ];

        
        $imagePath = public_path('images/Logo_HC_2.png');
        $logo = null; 

        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            $logo = 'data:' . $imageMime . ';base64,' . $imageData;
        }

        $headerData = [
            'logoDataUri' => $logo,
            'notaData' => $consentimiento,
            'paciente' => $consentimiento->estancia?->paciente,
            'medico' => $medicoFirmante, 
            'estancia'=> $consentimiento->estancia
        ];
        return Pdf::view($consentimiento->route_pdf, $viewData)
            ->format('Letter')
            ->name('consentimiento-' . ($consentimiento->estancia->folio ?? 'SN') . '.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) {
                $this->configureBrowsershot($browsershot);
            })
            ->headerView('headerConsentimiento', $headerData)
            ->inline();
    }
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
