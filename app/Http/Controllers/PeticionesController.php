<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estancia;
use Inertia\Inertia; // <--- ESTA ES LA IMPORTACIÓN QUE FALTA
use Illuminate\Support\Facades\Log; // Útil por si quieres debugear

class PeticionesController extends Controller
{
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
                // Recolectamos todos los medicamentos
                $todosLosMedicamentos = $estancia->formularioInstancias->flatMap(function ($instancia) {
                    return $instancia->hojaEnfermeria ? $instancia->hojaEnfermeria->hojaMedicamentos : [];
                });

                // Buscamos el ID de la Hoja de Enfermería que tenga medicamentos solicitados
                // para que el botón "Surtir" nos mande a la hoja correcta
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

        return Inertia::render('peticiones/index', [
            'peticiones' => $peticionesAgrupadas
        ]);
    }
}