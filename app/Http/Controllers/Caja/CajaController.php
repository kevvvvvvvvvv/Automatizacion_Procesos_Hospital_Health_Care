<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Exception;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\Caja;

use App\Enums\EstadoSesionCaja;
use App\Enums\TipoMovimientoCaja;

use App\Http\Resources\Caja\SesionCajaResource;

use App\Services\CajaService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CajaController extends Controller
{
    public function __construct(private CajaService $cajaService)
    {
    }

    public function index(Request $request)
    {
        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA->value)
            ->with('movimientos')
            ->first();

        $sesionData = $sesion ? new SesionCajaResource($sesion) : null;
        $cajas = Caja::where('tipo','operativa')->get();

        return Inertia::render('caja/index', [
            'sesionActiva' => $sesionData,
            'cajas' => $cajas, 
        ]);
    }

    /**
     * Obtiene el turno activo del usuario autenticado.
     */
    public function turnoActual(Request $request)
    {
        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->first();

        if (!$sesion) {
            return response()->json(['message' => 'No tienes ningún turno abierto.'], 404);
        }

        return new SesionCajaResource($sesion);
    }

    /**
     * Abre un nuevo turno de caja.
     */
    public function abrirTurno(Request $request)
    {
        $validated = $request->validate([
            'caja_id' => 'required|exists:cajas,id',
            'monto_inicial' => 'required|numeric|min:0',
        ]);

        $this->cajaService->abrirTurno(
            $validated['caja_id'],
            $request->user()->id,
            $validated['monto_inicial']
        );

        // Al estilo Inertia: Redirigimos de vuelta. 
        // Inertia detecta esto y recarga la página 'caja/index' con los nuevos props automáticamente.
        return redirect()->back()->with('success', 'Turno de caja abierto correctamente.');
    }

    /**
     * Registra un movimiento (ingreso/egreso) manual en la caja activa.
     */
    public function registrarMovimiento(Request $request)
    {
        $validated = $request->validate([
            'tipo' => ['required', new Enum(TipoMovimientoCaja::class)],
            'monto' => 'required|numeric|min:0.01',
            'concepto' => 'required|string|max:255',
        ]);

        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->firstOrFail();

        try {
            $this->cajaService->registrarMovimiento(
                $sesion,
                TipoMovimientoCaja::from($validated['tipo']),
                $validated['monto'],
                $validated['concepto'],
                $request->user()->id
            );
            return Redirect::back()->with('success', 'Movimiento registrado correctamente.');
            
        } catch (Exception $e) {
            \Log::error('Error al registrar el movimiento: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al registrar moviemiento.');
        }
    }

    /**
     * Realiza el corte y cierra la caja.
     */
    public function cerrarTurno(Request $request)
    {
        $validated = $request->validate([
            'monto_declarado' => 'required|numeric|min:0',
            'desglose' => 'nullable|array', 
            'desglose.*.denominacion' => 'required_with:desglose|numeric|min:0.1',
            'desglose.*.cantidad' => 'required_with:desglose|integer|min:1',
            'desglose.*.total' => 'required_with:desglose|numeric',
        ]);

        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->firstOrFail();

        try {
            $this->cajaService->cerrarTurno(
                $sesion,
                $validated['monto_declarado'],
                $validated['desglose'] ?? []
            );

            return redirect()->back()->with('success', 'Caja cerrada exitosamente.');
            
        } catch (Exception $e) {
            \Log::error('Error al cerrar el turno: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al cerrar el turno.');
        }
    }
}
