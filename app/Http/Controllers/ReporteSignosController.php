<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Log;

class ReporteSignosController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

   public function showFrecuenciaCardiaca(Request $request)
{
    $pacienteId = $request->input('paciente_id');
    
    $datos = DB::table('hoja_registros')
        ->join('hoja_enfermerias', 'hoja_registros.hoja_enfermeria_id', '=', 'hoja_enfermerias.id')
        // Unimos con estancias para poder filtrar por paciente_id
        ->join('estancias', 'hoja_enfermerias.estancia_id', '=', 'estancias.id') 
        ->select(
            'hoja_registros.fecha_hora_registro as fecha',
            'hoja_registros.frecuencia_cardiaca as fc',
            'hoja_registros.frecuencia_respiratoria as fr',
            'hoja_registros.temperatura as temp',
            'hoja_registros.tension_arterial_sistolica as sis',
            'hoja_registros.tension_arterial_diastolica as dias'
        )
        // Ahora filtramos usando la tabla estancias que sí tiene paciente_id
        ->where('estancias.paciente_id', $pacienteId) 
        ->orderBy('hoja_registros.fecha_hora_registro', 'asc')
        ->get();

    return Inertia::render('reportes/frecuenciaRep', [
        'registros' => $datos,
        'paciente' => DB::table('pacientes')->where('id', $pacienteId)->first(),
        'listaPacientes' => DB::table('pacientes')->select('id', 'nombre_completo')->get()
    ]);
}

    public function descargarPdfFrecuencia(Request $request)
    {
        // ... (Lógica similar al show para obtener $datos)
        // Usar $this->pdfGenerator->generateStandardPdf(...)
    }
}