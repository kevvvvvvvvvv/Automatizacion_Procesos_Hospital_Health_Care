<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Services\PdfGeneratorService; 

class LigaFutbolController extends Controller
{
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
                // Obtenemos la ruta de chrome desde el config (asegúrate que esté en services.php)
                $chromePath = config('services.browsershot.chrome_path');
                
                if ($chromePath) {
                    $browsershot->setChromePath($chromePath);
                }

                // Configuraciones esenciales para que rinda bien en el servidor
                $browsershot->noSandbox()
                    ->windowSize(1200, 1600) // Ayuda a que Tailwind renderice mejor
                    ->addChromiumArguments([
                        'disable-dev-shm-usage',
                        'disable-gpu',
                    ]);
            })
            // Usamos inline para que se vea en el navegador
            ->inline('formato-liga-futbol-' . date('Y-m-d') . '.pdf');
    }
}