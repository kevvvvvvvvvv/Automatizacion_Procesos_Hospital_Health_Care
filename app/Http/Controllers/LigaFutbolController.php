<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService; 

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
        ->name('formato-liga-futbol-' . date('Y-m-d') . '.pdf');
}
}