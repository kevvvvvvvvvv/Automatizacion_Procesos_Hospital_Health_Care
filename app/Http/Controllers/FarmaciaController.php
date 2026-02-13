<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Services\VentaService; 
use App\Models\HojaMedicamento; 
use Illuminate\Support\Facades\DB;

use App\Models\HojaEnfermeria;
use App\Models\Estancia;

use Inertia\Inertia;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;

class FarmaciaController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar peticion medicamentos', only: ['index', 'show']),
            new Middleware($permission . ':crear peticion medicamentos', only: ['create', 'store']),
            new Middleware($permission . ':eliminar peticion medicamentos', only: ['destroy']),
        ];
    }

    public function show(HojaEnfermeria $hojasenfermeria)
    {
        $hojasenfermeria->load([
            'formularioInstancia.estancia.paciente',
            'hojaMedicamentos' => function ($query) {
                $query->whereIn('estado', ['solicitado', 'surtido']);
            },
            'hojaMedicamentos.productoServicio' 
        ]);

        return Inertia::render('farmacia/show', [
            'hoja' => $hojasenfermeria,
            'paciente' => $hojasenfermeria->formularioInstancia->estancia->paciente,
        ]);
    }

    public function index()
    {
        $peticionesAgrupadas = Estancia::with([
                'paciente',
                'formularioInstancias.hojaEnfermeria.hojaMedicamentos' => function ($query) {
                    $query->where('estado', 'solicitado');
                },
                'formularioInstancias.hojaEnfermeria.hojaMedicamentos.productoServicio'
            ])
            ->whereHas('formularioInstancias.hojaEnfermeria.hojaMedicamentos', function ($query) {
                $query->where('estado', 'solicitado');
            })
            ->get()
            ->map(function ($estancia) {
                $todosLosMedicamentos = $estancia->formularioInstancias->flatMap(function ($instancia) {
                    return $instancia->hojaEnfermeria ? $instancia->hojaEnfermeria->hojaMedicamentos : [];
                });

                $instanciaConMedicamento = $estancia->formularioInstancias->first(function($instancia) {
                    return $instancia->hojaEnfermeria && $instancia->hojaEnfermeria->hojaMedicamentos->count() > 0;
                });

                return [
                    'estancia_id' => $estancia->id,
                    'paciente' => $estancia->paciente,
                    'total_items' => $todosLosMedicamentos->count(),
                    'resumen' => $todosLosMedicamentos->take(3)->map(fn($m) => $m->productoServicio->nombre ?? 'N/A'),
                    'hoja_enfermeria_id' => $instanciaConMedicamento ? $instanciaConMedicamento->id : null,
                ];
            });

        return Inertia::render('farmacia/index', [
            'peticiones' => $peticionesAgrupadas
        ]);
    }

}
