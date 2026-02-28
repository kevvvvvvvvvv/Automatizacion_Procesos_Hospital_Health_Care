<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Log;

class ReporteConcienciaController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function showReporteEscalas(Request $request)
    {
        // Validamos la escala y las fechas
        $filtros = $request->validate([
            'escala'       => 'required|in:escala_braden,escala_glasgow,escala_ramsey',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        dd($filtros);
        $columna = $filtros['escala'];
        
        $datos = DB::table('hoja_escala_valoracions')
            ->select($columna . ' AS puntaje', DB::raw('COUNT(*) AS total'))
            ->whereNotNull($columna)
            ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                return $query->whereDate('fecha_hora_registro', '>=', $filtros['fecha_inicio']);
            })
            ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                return $query->whereDate('fecha_hora_registro', '<=', $filtros['fecha_fin']);
            })
            ->groupBy($columna)
            ->orderBy('total', 'desc')
            ->get();

        return Inertia::render('reportes/concienciaRep', [
            'reporte' => $datos,
            'filtros' => $filtros
        ]);
    }

    public function descargarPdfEscalas(Request $request)
    {
        try {
            $escala = $request->input('escala', 'escala_glasgow');
            
            $datos = DB::table('hoja_escala_valoracions')
                ->select($escala . ' AS puntaje', DB::raw('COUNT(*) AS total'))
                ->whereNotNull($escala)
                ->groupBy($escala)
                ->orderBy('total', 'desc')
                ->get();

            $viewData = [
                'reporte' => $datos,
                'escala_nombre' => strtoupper(str_replace('_', ' ', $escala)),
                'fecha_reporte' => now()->format('d/m/Y H:i')
            ];

            return $this->pdfGenerator->generateStandardPdf(
                'pdfs.reporte-escalas',
                $viewData,
                ['titulo' => 'REPORTE DE FRECUENCIA EN ESCALAS'],
                'reporte-escalas-',
                now()->format('His')
            );
        } catch (\Exception $e) {
            Log::error('Error PDF Escalas: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}