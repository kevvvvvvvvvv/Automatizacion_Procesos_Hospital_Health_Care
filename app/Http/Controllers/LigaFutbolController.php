<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService; 
use Spatie\Browsershot\Browsershot;

class LigaFutbolController extends Controller
{
    // Definimos la propiedad
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function generarPdf()
    {
        $data = [
            'fecha_hoy' => date('d/m/Y'),
            'folio'     => 'S/F',
            'paciente'  => null, 
            'tutor'     => null,
        ];

    return Pdf::view('pdfs.liga-futbol', $data)
        ->withBrowsershot(function (Browsershot $browsershot) {
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
        ->name('formato-liga-futbol-' . date('Y-m-d') . '.pdf');
}
}