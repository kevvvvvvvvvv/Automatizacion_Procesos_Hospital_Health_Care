<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Inertia\Inertia;

use App\Services\CajaService;

use App\Enums\TipoMovimientoCaja;
use App\Enums\EstadoSesionCaja;
use App\Http\Requests\Caja\Contaduria\IndexRequest;
use App\Http\Requests\Caja\Contaduria\ContaduriaRequest;
use App\Models\Caja\SolicitudTraspaso;
use App\Models\Caja\Caja;
use App\Models\Caja\SesionCaja;
use App\Models\Caja\MovimientoCaja;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;


class ContaduriaController extends Controller
{
    public function index(IndexRequest $request)
    {
        // 1. Manejo de Fecha (Paginación por día)
        $fechaFiltro = $request->input('fecha', Carbon::today()->format('Y-m-d'));
        $fechaCarbon = Carbon::parse($fechaFiltro);

        // 2. Validación de turno único (Caja 3)
        $turnoExistente = SesionCaja::where('caja_id', 3)->where('estado', 'abierta')->first();
        if ($turnoExistente && ($turnoExistente->user_id !== Auth::id())) {
            return Redirect::back()->with('error', 'Ya existe un turno abierto para esta caja por otro usuario.'); 
        }

        // 3. Cajas maestras
        $cajasMaestras = Caja::whereIn('tipo', ['boveda', 'fondo', 'operativo'])->get();
        $cBoveda = $cajasMaestras->where('tipo', 'boveda')->first();
        $cFondo = $cajasMaestras->where('tipo', 'fondo')->first();
        $cOperativo = $cajasMaestras->where('tipo', 'operativo')->first();

        // 4. Auto-apertura de Sesiones Maestras (Bóveda y Fondo)
        $sesionBoveda = SesionCaja::firstOrCreate(
            ['caja_id' => $cBoveda->id, 'estado' => 'abierta'],
            ['user_id' => Auth::id(), 'fecha_apertura' => now(), 'monto_inicial' => 50000]
        );

        $sesionesFondo = SesionCaja::with('caja') 
            ->whereHas('caja', function ($query) {
                $query->where('tipo', 'fondo');
            })
            ->where('estado',EstadoSesionCaja::ABIERTA->value)
            ->get();

        // 5. Movimientos del DÍA SELECCIONADO (Aquí está la "paginación")
        $movimientosFiltro = MovimientoCaja::with(['sesionCaja.caja', 'user', 'metodoPago'])
            ->whereDate('created_at', $fechaCarbon)
            ->latest()
            ->get();

        $ingresos = $movimientosFiltro->where('tipo', 'ingreso')->sum('monto');
        $egresos = $movimientosFiltro->where('tipo', 'egreso')->sum('monto');

        // 6. Otras Consultas
        $solicitudes = SolicitudTraspaso::with(['cajaDestino', 'usuarioSolicita'])
            ->where('estado', 'pendiente')
            ->latest()
            ->get();
        
        
        $movimientosHoy = MovimientoCaja::with(['sesionCaja.caja', 'user','metodoPago'])
/*             ->whereDate('created_at', Carbon::today())
            ->latest() */
            ->get();

        $ingresosHoy = $movimientosHoy->where('tipo', 'ingreso')->sum('monto');
        $egresosHoy = $movimientosHoy->where('tipo', 'egreso')->sum('monto');
        $boveda = Caja::where('tipo', 'boveda')->firstOrFail();

        $cajaFondo = Caja::where('tipo', 'fondo')->firstOrFail();

        $fondo = SesionCaja::where('caja_id', $cajaFondo->id)
            ->where('estado', 'abierta')
            ->with('movimientos.metodoPago')
            ->first();

        $sesionOperativo = SesionCaja::where('caja_id', $cOperativo->id)
            ->where('estado', 'abierta')
            ->first();

        // Sesiones para auditoría (últimos 3 días)
        $allSesiones = SesionCaja::with(['user', 'caja'])
            ->where('fecha_apertura', '>=', now()->subDays(3))
            ->orderBy('fecha_apertura', 'desc')
            ->get();;

        return Inertia::render('caja/dashboard-boveda', [
            'fechaFiltro' => $fechaFiltro, 
            'cajaId' => $cBoveda->id,
            'solicitudesPendientes' => $solicitudes,
            'movimientosHoy' => $movimientosFiltro,
            'resumenHoy' => [
                'ingresos' => $ingresos,
                'egresos' => $egresos,
                'balance' => $ingresos - $egresos
            ],
            'boveda' => $sesionBoveda,
            'fondos' => $sesionesFondo,
            'sesion' => $turnoExistente,
            'caja' => $sesionOperativo,
            'allSesiones' => $allSesiones,
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

    public function auditarSesion(Request $request, SesionCaja $sesion)
    {
        $validated = $request->validate([
            'monto_ajuste' => 'required|numeric',
            'observacion_auditoria' => 'required|string|min:10|max:1000',
        ], [
            'monto_ajuste.required' => 'Debes ingresar un monto, aunque sea 0.',
            'observacion_auditoria.required' => 'Es obligatorio dejar una nota del porqué del ajuste.',
            'observacion_auditoria.min' => 'La nota debe ser más descriptiva (mínimo 10 caracteres).',
        ]);

        $sesion->update([
            'auditada' => true,
            'monto_ajuste' => $validated['monto_ajuste'],
            'observacion_auditoria' => $validated['observacion_auditoria'],
            'auditor_id' => Auth::id(), 
            'fecha_auditoria' => now(),
        ]);

        return Redirect::back()->with('success', 'La sesión ha sido auditada y cerrada correctamente.');
    }

    public function traspasoDirectoBovedaFondo(Request $request)
    {
        $request->validate([
            'monto_envio' => 'required|numeric|min:0.01',
            'sesion_origen_id' => 'required|exists:sesion_cajas,id',
            'sesion_destino_id' => 'required|exists:sesion_cajas,id',
            'observacion' => 'nullable|string|max:255'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $monto = $request->monto_envio;
                $origen = SesionCaja::findOrFail($request->sesion_origen_id);
                $destino = SesionCaja::findOrFail($request->sesion_destino_id);

                $origen->increment('total_egresos_efectivo', $monto);
                MovimientoCaja::create([
                    'sesion_caja_id' => $origen->id,
                    'tipo' => 'egreso',
                    'monto' => $monto,
                    'concepto' => 'TRASPASO DIRECTO A FONDO',
                    'descripcion' => $request->observacion ?? 'Envío de efectivo para operación.',
                    'user_id' => Auth::id(),
                ]);

                $destino->increment('total_ingresos_efectivo', $monto);
                MovimientoCaja::create([
                    'sesion_caja_id' => $destino->id,
                    'tipo' => 'ingreso',
                    'monto' => $monto,
                    'concepto' => 'RECEPCIÓN DIRECTA DE BÓVEDA',
                    'descripcion' => 'Ingreso de efectivo desde contaduría.',
                    'user_id' => Auth::id(),
                ]);
            });

            return back()->with('success', 'Traspaso realizado con éxito.');

        } catch (\Exception $e) {
            return back()->withErrors(['monto_envio' => 'Error al procesar el traspaso: ' . $e->getMessage()]);
        }
    }
}
