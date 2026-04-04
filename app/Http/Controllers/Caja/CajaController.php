<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\Caja;

use App\Enums\EstadoSesionCaja;
use App\Enums\TipoMovimientoCaja;
use App\Http\Requests\Caja\Caja\AbrirTurnoRequest;
use App\Http\Requests\Caja\Caja\CerrarTurnoRequest;
use App\Http\Requests\Caja\Caja\RegistrarMovimientoRequest;
use App\Http\Resources\Caja\SesionCajaResource;
use App\Models\Venta\MetodoPago;
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
            ->with('movimientos.metodoPago')
            ->first();
        
        $cajaFondo = Caja::where('tipo', 'fondo')->firstOrFail();

        $fondo = SesionCaja::where('caja_id', $cajaFondo->id)
            ->where('estado', 'abierta')
            ->first();

        $sesionData = $sesion ? new SesionCajaResource($sesion) : null;
        $cajas = Caja::where('tipo','operativo')->get();

        $metodosPago = MetodoPago::all();

        return Inertia::render('caja/index', [
            'sesionActiva' => $sesionData,
            'cajas' => $cajas,
            'fondo' => $fondo,
            'metodos_pago' => $metodosPago,
        ]);
    }

    /**
     * Obtiene el turno activo del usuario autenticado.
     */
    public function turnoActual()
    {
        $sesion = SesionCaja::where('user_id', Auth::id())
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
    public function abrirTurno(AbrirTurnoRequest $request)
    {
        $validated = $request->validated();

        $this->cajaService->abrirTurno(
            $validated['caja_id'],
            $request->user()->id,
            $validated['monto_inicial']
        );

        return redirect()->back()->with('success', 'Turno de caja abierto correctamente.');
    }

    /**
     * Registra un movimiento (ingreso/egreso) manual en la caja activa.
     */
    public function registrarMovimiento(RegistrarMovimientoRequest $request)
    {
        $validated = $request->validated();

        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->firstOrFail();

        try {
            $this->cajaService->registrarMovimiento(
                $sesion,
                TipoMovimientoCaja::from($validated['tipo']),
                $validated['monto'],
                $validated['concepto'],
                Auth::id(),
                $validated['metodo_pago_id'],
                $validated['area'],
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
    public function cerrarTurno(CerrarTurnoRequest $request)
    {
        $validated = $request->validated();

        $sesion = SesionCaja::where('user_id', Auth::id())
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
