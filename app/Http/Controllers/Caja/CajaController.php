<?php

namespace App\Http\Controllers\Caja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Carbon;

use App\Models\Caja\SesionCaja;
use App\Models\Caja\Caja;

use App\Enums\EstadoSesionCaja;
use App\Enums\TipoMovimientoCaja;
use App\Http\Requests\Caja\Caja\AbrirTurnoRequest;
use App\Http\Requests\Caja\Caja\CerrarTurnoRequest;
use App\Http\Requests\Caja\Caja\IndexRequest;
use App\Http\Requests\Caja\Caja\RegistrarMovimientoRequest;
use App\Http\Resources\Caja\SesionCajaResource;
use App\Models\Caja\MovimientoCaja;
use App\Models\Venta\MetodoPago;
use App\Services\CajaService;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CajaController extends Controller
{
    public function __construct(private CajaService $cajaService)
    {
    }

    public function index(IndexRequest $request)
    {
        $fechaFiltrada = $request->input('fecha', Carbon::today()->format('Y-m-d'));
        $fechaCarbon = Carbon::parse($fechaFiltrada);

        //Sesion actual
        $sesion = SesionCaja::where('user_id', $request->user()->id)
            ->where('estado', EstadoSesionCaja::ABIERTA->value)
            ->with('movimientos.metodoPago')
            ->first();

        $movimientos = MovimientoCaja::where('user_id', Auth::id())
            ->whereDate('created_at',$fechaCarbon)
            ->latest()
            ->get();
        
        //Cajas disponibles
        $cajaFondo = Caja::where('tipo', 'fondo')->firstOrFail();

        //Fondo
        $fondo = SesionCaja::where('caja_id', $cajaFondo->id)
            ->where('estado', 'abierta')
            ->first();

        //Si hay una sesion en la caja operatica
        $sesionData = $sesion ? new SesionCajaResource($sesion) : null;
        $cajas = Caja::where('tipo','operativo')->get();

        $metodosPago = MetodoPago::all();

        return Inertia::render('caja/index', [
            'movimientos' => $movimientos,
            'sesionActiva' => $sesionData,
            'cajas' => $cajas,
            'fondo' => $fondo,
            'metodos_pago' => $metodosPago,
            'fecha_filtrada' =>$fechaCarbon->format('Y-m-d'),
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

        $existeTurno = SesionCaja::where('caja_id', $validated['caja_id'])
            ->where('estado', 'abierta')
            ->exists();

        if ($existeTurno) {
            return Redirect::back()->with('error', 'Ya existe un turno abierto para esta caja.'); 
        }

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
        $sesion = SesionCaja::where('user_id', Auth::id())
            ->where('estado', EstadoSesionCaja::ABIERTA)
            ->firstOrFail();

        try {
            $this->cajaService->registrarGastoConTriangulacion($sesion, $request->validated());

            return Redirect::back()->with('success', 'Movimiento registrado correctamente.');
        } catch (Exception $e) {
            \Log::error("Error en movimiento: " . $e->getMessage());
            return Redirect::back()->with('error', 'No se pudo procesar el movimiento.');
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
                $validated['monto_enviado_contaduria'],
                $validated['desglose'] ?? []
            );

            return redirect()->back()->with('success', 'Caja cerrada exitosamente.');
            
        } catch (Exception $e) {
            \Log::error('Error al cerrar el turno: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al cerrar el turno.');
        }
    }
}
