<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Log;

class ReporteEstanciaController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function showReporteEstancia(Request $request)
    {
        $filtros = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $datos = DB::table('estancias')
            ->select('tipo_estancia AS tipo', DB::raw('COUNT(id) AS total'))
            ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                return $query->whereDate('fecha_ingreso', '>=', $filtros['fecha_inicio']);
            })
            ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                return $query->whereDate('fecha_ingreso', '<=', $filtros['fecha_fin']);
            })
            ->groupBy('tipo_estancia')
            ->get();

        return Inertia::render('reportes/estanciasRep', [
            'estancias' => $datos,
            'filtros'   => $filtros 
        ]);
    }

    public function descargarReporteEstanciaPdf(Request $request)
    {
        try {
            $filtros = $request->validate([
                'fecha_inicio' => 'nullable|date',
                'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            ]);

            $datos = DB::table('estancias')
                ->select('tipo_estancia AS tipo', DB::raw('COUNT(id) AS total'))
                ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                    return $query->whereDate('fecha_ingreso', '>=', $filtros['fecha_inicio']);
                })
                ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                    return $query->whereDate('fecha_ingreso', '<=', $filtros['fecha_fin']);
                })
                ->groupBy('tipo_estancia')
                ->get();

            $viewData = [
                'estancias' => $datos,
                'filtros'   => $filtros,
                'fecha_reporte' => now()->format('d/m/Y H:i A')
            ];

            return $this->pdfGenerator->generateStandardPdf(
                'pdfs.reporte-estancias', 
                $viewData,
                ['titulo' => 'REPORTE POR TIPO DE ESTANCIA'],
                'reporte-tipo-estancia-',
                now()->format('His')
            );

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de estancias: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}