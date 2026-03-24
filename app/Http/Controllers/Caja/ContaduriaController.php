<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Models\Caja\SolicitudTraspaso;

class ContaduriaController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudTraspaso::with(['cajaDestino', 'usuarioSolicita'])
            ->where('estado', 'pendiente')
            ->latest() 
            ->get();

        return Inertia::render('caja/dashboard-boveda', [
            'solicitudesPendientes' => $solicitudes
        ]);
    }
}
