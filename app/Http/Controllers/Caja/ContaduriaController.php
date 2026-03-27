<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Inertia\Inertia;

use App\Models\Caja\SolicitudTraspaso;
use App\Models\Caja\Caja;
use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;


class ContaduriaController extends Controller
{
    public function index(Request $request)
    {
        // Cajas maestras
        $boveda = Caja::where('tipo', 'boveda')->firstOrFail();
        $fondo = Caja::where('tipo', 'fondo')->firstOrFail();

        // Se busca sesion abiertas, si no se encuentra se crea
        SesionCaja::firstOrCreate(
            ['caja_id' => $boveda->id, 'estado' => 'abierta'],
            [
                'user_id' => $request->user()->id,
                'fecha_apertura' => now(),
                'monto_inicial' => 0,
                'monto_esperado' => 0,
            ]
        );

        SesionCaja::firstOrCreate(
            ['caja_id' => $fondo->id, 'estado' => 'abierta'],
            [
                'user_id' => $request->user()->id,
                'fecha_apertura' => now(),
                'monto_inicial' => 0,
                'monto_esperado' => 0,
            ]
        );
        $solicitudes = SolicitudTraspaso::with(['cajaDestino', 'usuarioSolicita'])
            ->where('estado', 'pendiente')
            ->latest()
            ->get();
        
        
        $movimientosHoy = MovimientoCaja::with(['sesionCaja.caja', 'user'])
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        $ingresosHoy = $movimientosHoy->where('tipo', 'ingreso')->sum('monto');
        $egresosHoy = $movimientosHoy->where('tipo', 'egreso')->sum('monto');

        return Inertia::render('caja/dashboard-boveda', [
            'solicitudesPendientes' => $solicitudes,
            'movimientosHoy' => $movimientosHoy,
            'resumenHoy' => [
                'ingresos' => $ingresosHoy,
                'egresos' => $egresosHoy,
                'balance' => $ingresosHoy - $egresosHoy
            ]
        ]);
    }
}
