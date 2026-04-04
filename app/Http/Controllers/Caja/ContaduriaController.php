<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Inertia\Inertia;

use App\Services\CajaService;

use App\Enums\TipoMovimientoCaja;
use App\Enums\EstadoSesionCaja;

use App\Http\Requests\Caja\Contaduria\ContaduriaRequest;
use App\Models\Caja\SolicitudTraspaso;
use App\Models\Caja\Caja;
use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;

use Illuminate\Support\Facades\Auth;

class ContaduriaController extends Controller
{
    public function index()
    {
        // Cajas maestras
        $boveda = Caja::where('tipo', 'boveda')->firstOrFail();
        $fondo = Caja::where('tipo', 'fondo')->firstOrFail();

        // Se busca sesion abiertas, si no se encuentra se crea
        SesionCaja::firstOrCreate(
            ['caja_id' => $boveda->id, 'estado' => 'abierta'],
            [
                'user_id' => Auth::id(),
                'fecha_apertura' => now(),
                'monto_inicial' => 50000,
            ]
        );

        SesionCaja::firstOrCreate(
            ['caja_id' => $fondo->id, 'estado' => 'abierta'],
            [
                'user_id' => Auth::id(),
                'fecha_apertura' => now(),
                'monto_inicial' => 10000,
            ]
        );
        $solicitudes = SolicitudTraspaso::with(['cajaDestino', 'usuarioSolicita'])
            ->where('estado', 'pendiente')
            ->latest()
            ->get();
        
        
        $movimientosHoy = MovimientoCaja::with(['sesionCaja.caja', 'user','metodoPago'])
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get();

        $ingresosHoy = $movimientosHoy->where('tipo', 'ingreso')->sum('monto');
        $egresosHoy = $movimientosHoy->where('tipo', 'egreso')->sum('monto');
        $boveda = Caja::where('tipo', 'boveda')->firstOrFail();

        $cajaFondo = Caja::where('tipo', 'fondo')->firstOrFail();

        $fondo = SesionCaja::where('caja_id', $cajaFondo->id)
            ->where('estado', 'abierta')
            ->first();
        
        $sesion = SesionCaja::where('user_id', Auth::id())
            ->where('estado', EstadoSesionCaja::ABIERTA->value)
            ->with('movimientos.metodoPago')
            ->first();

        $caja = Caja::where('tipo', 'operativo')->firstOrFail();

        $caja = SesionCaja::where('caja_id', $caja->id)
            ->where('estado', 'abierta')
            ->first();

        return Inertia::render('caja/dashboard-boveda', [
            'cajaId' => $boveda->id,
            'solicitudesPendientes' => $solicitudes,
            'movimientosHoy' => $movimientosHoy,
            'resumenHoy' => [
                'ingresos' => $ingresosHoy,
                'egresos' => $egresosHoy,
                'balance' => $ingresosHoy - $egresosHoy
            ],
            'fondo' => $fondo,
            'sesion' => $sesion,
            'caja' => $caja
        ]);
    }

    public function registrarGasto(ContaduriaRequest $request, CajaService $cajaService)
    {
        $validated = $request->validated();

        $sesion = SesionCaja::where('caja_id', $validated['caja_origen_id'])
                            ->where('estado', 'abierta')
                            ->firstOrFail();

        $cajaService->registrarMovimiento(
            $sesion,
            TipoMovimientoCaja::EGRESO,
            $validated['monto'],
            "Gasto externo: " . $validated['concepto'],
            $request->user()->id
        );

        return redirect()->back()->with('success', 'Pago / Gasto externo registrado correctamente.');
    }
}
