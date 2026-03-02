<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Log;

class ReporteInterconsultaController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function showFrecuenciaMotivos(Request $request)
    {
        $filtros = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        // Agrupamos por el texto del motivo y contamos frecuencias
        $datos = DB::table('interconsultas')
            ->select('motivo_de_la_atencion_o_interconsulta AS motivo', DB::raw('COUNT(*) AS total'))
            ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                return $query->whereDate('created_at', '>=', $filtros['fecha_inicio']);
            })
            ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                return $query->whereDate('created_at', '<=', $filtros['fecha_fin']);
            })
            ->groupBy('motivo_de_la_atencion_o_interconsulta')
            ->orderBy('total', 'desc')
            ->limit(15) // Top 15 motivos más frecuentes
            ->get();

        return Inertia::render('reportes/interconsultaRep', [
            'reporte' => $datos,
            'filtros' => $filtros 
        ]);
    }

    public function descargarPdfMotivos(Request $request)
    {
        try {
            $filtros = $request->all();

            $datos = DB::table('interconsultas')
                ->select('motivo_de_la_atencion_o_interconsulta AS motivo', DB::raw('COUNT(*) AS total'))
                ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                    return $query->whereDate('created_at', '>=', $filtros['fecha_inicio']);
                })
                ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                    return $query->whereDate('created_at', '<=', $filtros['fecha_fin']);
                })
                ->groupBy('motivo_de_la_atencion_o_interconsulta')
                ->orderBy('total', 'desc')
                ->get();

            $viewData = [
                'reporte' => $datos,
                'filtros' => $filtros,
                'fecha_reporte' => now()->format('d/m/Y H:i')
            ];

            return $this->pdfGenerator->generateStandardPdf(
                'pdfs.reporte-motivos-interconsulta',
                $viewData,
                ['titulo' => 'FRECUENCIA DE MOTIVOS DE INTERCONSULTA'],
                'reporte-motivos-',
                now()->format('Ymd')
            );

        } catch (\Exception $e) {
            Log::error('Error PDF Motivos: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}