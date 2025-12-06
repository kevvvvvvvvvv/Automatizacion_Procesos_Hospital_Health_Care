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

class ConsentimientoController extends Controller


{
    protected PdfGeneratorService $pdfGenerator;

        public function __construct(PdfGeneratorService $pdfGenerator)
        {
            $this->pdfGenerator = $pdfGenerator;
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
            '1' => 'Consentimiento_cirugua_mayor',
            '2' => 'Consentimiento_informado_bajo_informacion_anestesico',
            '3' => 'Consentimiento_Salpingoclasia_vasectomia',
            '4' => 'Consentimiento_organos_tejidos_trasplantes',
            '5' => 'Consentimiento_investigacion',
            '6' => 'Consentimiento_necropsia_hospitalaria',
            '7' => 'Consentimiento_diagnostico_terapeutico',
            '8' => 'Consentimiento_mutilacion',
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
                    'diagnostico' => $key === 'otro' ? $diagnostico : null,
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

        $viewData = [
            'notaData' => $consentimiento,
            'paciente' => $consentimiento->estancia?->paciente,
            'medico' => $consentimiento->user,
        ];
    } else {
        // Carga por defecto si no viene ID específico
        $consentimiento->load('estancia', 'user.credenciales');
        // Asegúrate de pasar los datos mínimos necesarios a la vista por defecto también
        $viewData = [
            'notaData' => $consentimiento, 
            'user' => Auth::user()
        ];
    }

    // 2. Generación DIRECTA del PDF (Sin usar el servicio externo)
    return Pdf::view($consentimiento->route_pdf, $viewData)
        ->format('Letter') // Formato carta
        ->name('consentimiento-' . ($consentimiento->estancia->folio ?? 'SN') . '.pdf')
        ->withBrowsershot(function (Browsershot $browsershot) {
            // Aquí llamamos a TU función protegida que ya tienes en la clase
            $this->configureBrowsershot($browsershot);
            
            // Opcional: Si el header molestaba por márgenes, aquí puedes forzar márgenes limpios
            // $browsershot->margins(10, 10, 10, 10); 
        })
        ->download(); // O ->download() si prefieres que se descargue directo
}

// Asegúrate de tener esta función en tu controlador (o en un Trait que use el controlador)
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

/*
    public function generarPDF(Paciente $paciente, Estancia $estancia, Consentimiento $consentimiento)
    {
        $consentimiento->load(
            'estancia',
            'user.credenciales',
        );
        $paciente = $consentimiento->estancia->paciente;
        $medico = $consentimiento->user;
        $estancia = $consentimiento->estancia;

        $headerData = [
            'consentimiento' => $consentimiento,
            'paciente' => $paciente,
            'estancia' => $estancia, 
        ];

        $viewData = [
            'notaData' => $consentimiento,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.consentimiento',
            $viewData,
            $headerData,
            'consentimiento',
            $estancia->folio
        );
    } */

}
