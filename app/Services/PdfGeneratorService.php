<?php

namespace App\Services;

use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Str;

class PdfGeneratorService
{
    /**
     * Genera un PDF de forma estandarizada.
     *
     * @param string $viewName El nombre de la vista principal del PDF (e.g., 'pdfs.preoperatoria').
     * @param array $data Los datos a pasar a la vista principal.
     * @param array $headerData Los datos a pasar a la vista del encabezado.
     * @param string $fileNameBase La base para el nombre del archivo (e.g., 'nota-preoperatoria').
     * @param string $folio El folio o identificador para el nombre del archivo.
     * @return \Illuminate\Http\Response
     */
    public function generateStandardPdf(
        string $viewName,
        array $data,
        array $headerData,
        string $fileNameBase,
        string $folio
    ) {
        $logoDataUri = $this->getLogoDataUri('images/Logo_HC_2.png');
        $headerData['logoDataUri'] = $logoDataUri;
        $pdf = Pdf::view($viewName, $data)
            ->withBrowsershot(function (Browsershot $browsershot) {
                $this->configureBrowsershot($browsershot);
            })
            ->headerView('header', $headerData) 
            ->inline($fileNameBase . '-' . $folio . '.pdf');

        return $pdf;
    }

    /**
     * Configura Browsershot con ajustes comunes.
     *
     * @param Browsershot $browsershot
     * @return void
     */
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
    
    /**
     * Obtiene el Data URI del logo.
     *
     * @param string $path
     * @return string
     */
    protected function getLogoDataUri(string $path): string
    {
        $imagePath = public_path($path);
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            return 'data:' . $imageMime . ';base64,' . $imageData;
        }
        return '';
    }
}