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
            $chromePath = config('services.browsershot.chrome_path');
            
            if ($chromePath) {
                $browsershot->setChromePath($chromePath);
            }

            $browsershot
                ->noSandbox()
                ->windowSize(1200, 1600)
                // Esto es vital en producción para evitar errores de timeout y permisos
                ->setOption('args', [
                    '--disable-setuid-sandbox',
                    '--no-zygote',
                ])
                ->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                ]);
            
            // Si usas NVM o Node no está en la ruta global, descomenta esto:
            // $browsershot->setIncludePath('$PATH:/usr/local/bin:/usr/bin');
        })
        ->inline('formato-liga-futbol-' . date('Y-m-d') . '.pdf');
}
}