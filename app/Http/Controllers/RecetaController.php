<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;   
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\Formulario\Interconsulta\Interconsulta;
use App\Models\Formulario\NotaUrgencia\NotaUrgencia;

class RecetaController extends Controller
{   
    protected $pdfGenerator;
    use AuthorizesRequests;
    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }
    public function generar($tipo, $id)
{
    // 1. Determinar el modelo según el tipo
    if ($tipo === 'interconsulta') {
        $registro = Interconsulta::with(['formularioInstancia.estancia.paciente', 'formularioInstancia.user'])->findOrFail($id);
    } elseif ($tipo === 'urgencia') {
        $registro = NotaUrgencia::with(['formularioInstancia.estancia.paciente', 'formularioInstancia.user'])->findOrFail($id);
    } else {
        return abort(404, "Tipo de receta no válido");
    }
  
    $instancia = $registro->formularioInstancia;
   // dd($registro);
    // 2. Mapeo de datos (Como ambos usan formularioInstancia, el resto es igual)
    
    
    $headerData = [
            'historiaclinica' => $registro,
            'paciente' => $instancia->estancia->paciente,
            'estancia' => $instancia->estancia
        ];
    $viewData = [
        'tratamiento' => $registro->tratamiento, // Asegúrate que ambos modelos tengan este campo
        'paciente'    => $instancia->estancia->paciente,
        'medico'      => $instancia->user,
        'fecha'       => $instancia->fecha_hora,
    ];
    
    //dd($viewData);
    return $this->pdfGenerator->generateStandardPdf(
        'pdfs.receta', 
        $viewData,
        $headerData,
        'receta-' ,
        $instancia->estancia->folio
    );
}
}
