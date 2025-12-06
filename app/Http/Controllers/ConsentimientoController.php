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
                'user_id' => auth()->id(),
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
            $consentimiento->load(
                'estancia',
                'user.credenciales',
            );


            $file = urldecode($file);
            $file = str_replace(['../','..\\'], '', $file);
            $file = trim($file, "/ \\\0");
            $file = preg_replace('/\.blade\.php$|\.php$|\.pdf$/i', '', $file);

            $viewPath = '' . str_replace(['/', '\\'], '.', $file);

            if (! view()->exists($viewPath)) {
                Log::warning("generarPDF: plantilla no encontrada: {$viewPath}");
                abort(404, "Plantilla no encontrada: {$viewPath}");
            }

            $viewData = ['user' => auth()->user()];
            $headerData = [];
            $folio = null;

            if ($request->has('consentimiento_id')) {
                $consentimientoId = intval($request->query('consentimiento_id'));
                $consentimiento = Consentimiento::with('estancia.paciente', 'user.credenciales')->find($consentimientoId);

                if (! $consentimiento) abort(404, "Consentimiento no encontrado.");

                $consentimiento->loadMissing('estancia', 'user');

                $viewData = [
                    'notaData' => $consentimiento,
                    'paciente' => $consentimiento->estancia?->paciente,
                    'medico' => $consentimiento->user,
                ];

                $headerData = [
                    'consentimiento' => $consentimiento,
                    'paciente' => $consentimiento->estancia?->paciente,
                    'estancia' => $consentimiento->estancia,
                ];

               
            }

            // Generar PDF con la vista
            $pdf = Pdf::View($viewPath, $viewData);

            return $this->pdfGenerator->generateStandardPdf(
            $consentimiento -> route_pdf,
            $viewData,
            $headerData,
            'consentimiento',
            $estancia->folio
        );
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
