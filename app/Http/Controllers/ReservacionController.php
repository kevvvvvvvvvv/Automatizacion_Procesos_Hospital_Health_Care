<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Habitacion;
use App\Models\ReservacionHorario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

use App\Http\Requests\ReservacionRequest;
use App\Models\HabitacionPrecio;
use Illuminate\Support\Facades\Redirect;

class ReservacionController extends Controller
{

    public function index()
    {
        $query = Reservacion::with([
            'user', 
            'horarios.habitacionPrecio.habitacion' 
        ])
        ->orderBy('fecha', 'desc');

        if (! Auth::user()->hasRole('administrador')) {
            $query->where('user_id', Auth::id());
        }

        $reservaciones = $query->get();

        return Inertia::render('reservacion/index', [
            'reservaciones' => $reservaciones
        ]);
    }

    public function reserva(){
         $reservaciones = Reservacion::with([
            'horarios.habitacionPrecio.habitacion',
            'user:id,nombre'
        ])
        ->orderBy('fecha', 'desc')
        ->get();

        return Inertia::render('reservacion/reserva', [
            'reservaciones' => $reservaciones
        ]);
    
    }

    public function show(Reservacion $reservacione)
    {
        $reservacione->load([
            'user', 
            'horarios.habitacionPrecio.habitacion' 
        ]);

        return Inertia::render('reservacion/show', [
            'reservacion' => $reservacione,
            'expira_en'   => $reservacione->created_at->addMinutes(10)->toISOString(), 
        ]);
    }
   
    public function create(Request $request)
    {
        $fechaSeleccionada = $request->input('fecha', now()->format('Y-m-d'));

        $ocupacion = DB::table('reservacion_horarios')
            ->select(
                'habitaciones.ubicacion',
                'habitacion_precios.horario_inicio',
                DB::raw('count(*) as total_ocupados')
            )
            ->join('habitacion_precios', 'reservacion_horarios.habitacion_precio_id', '=', 'habitacion_precios.id')
            ->join('habitaciones', 'habitacion_precios.habitacion_id', '=', 'habitaciones.id')
            ->join('reservaciones', 'reservacion_horarios.reservacion_id', '=', 'reservaciones.id')
            ->where('reservacion_horarios.fecha', $fechaSeleccionada)
            ->whereIn('reservaciones.estatus', ['pendiente', 'pagado']) 
            ->where('habitaciones.tipo', 'Consultorio')
            ->groupBy('habitaciones.ubicacion', 'habitacion_precios.horario_inicio')
            ->get();

        $mapaOcupacion = $ocupacion->mapWithKeys(function ($item) {
            $clave = $item->ubicacion . '|' . $item->horario_inicio;
            return [$clave => $item->total_ocupados];
        });

        $limitesPorSede = Habitacion::where('tipo', 'Consultorio')
            ->select('ubicacion', DB::raw('count(*) as total'))
            ->groupBy('ubicacion')
            ->pluck('total', 'ubicacion');

        return Inertia::render('reservacion/create', [
            'limitesDinamicos' => $limitesPorSede,
            'ocupacionActual'  => $mapaOcupacion, 
            'fechaSeleccionada'=> $fechaSeleccionada, 
            'ubicaciones'      => Habitacion::select('ubicacion')->distinct()->get(),
        ]);
    }

    public function store(ReservacionRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            $procesado = $this->procesarDisponibilidad(
                $data['localizacion'], 
                $data['fecha'], 
                $data['horarios']
            );

            $reservacion = Reservacion::create([
                'fecha'        => $data['fecha'],
                'localizacion' => $data['localizacion'], 
                'pago_total'        => $procesado['total'],
                'estatus'      => 'pendiente',
                'user_id'      => Auth::id(),
            ]);

            $reservacion->horarios()->createMany($procesado['detalles']);
            DB::commit();
            return redirect()
                ->route('reservaciones.show', $reservacion->id)
                ->with('success', 'Reservación registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Fallo al reservar: ' . $e->getMessage());
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    public function edit(Reservacion $reservacion)
    {

    }

    public function update(ReservacionRequest $request, Reservacion $reservacion)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            DB::commit();
            return redirect()->route('reservaciones.index')->with('success', 'Reservación actualizada.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al actualizar la reservación: ' .  $e->getMessage());
            return Redirect::back()->with('error','Error al actualizar la reservación.');
        }
    }

    public function pagar(Request $request, Reservacion $reservacione)
    {
        if ($reservacione->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($reservacione->estatus === 'pagado') {
            return response()->json(['message' => 'Esta reservación ya fue pagada.'], 400);
        }

        if ($reservacione->created_at->diffInMinutes(now()) > 10) {
            return response()->json(['message' => 'El tiempo de pago ha expirado.'], 422);
        }

        $request->validate(['payment_method' => 'required|string']);

        try {

            $montoPactado = $reservacione->pago_total; 
            $totalCentavos = (int) round($montoPactado * 100);
            if ($totalCentavos < 1000) { 
                throw new \Exception("Error: El monto a pagar ($$montoPactado) es inválido o es $0.00. Contacta a soporte.");
            }

            $user = Auth::user();

            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer();
            }

            $charge = $user->charge($totalCentavos, $request->input('payment_method'), [
                'currency' => 'mxn', 
                'description' => "Pago de Reservación #" . $reservacione->id,
                'metadata' => ['reservacion_id' => $reservacione->id],
                'return_url'  => route('reservaciones.show', $reservacione->id),
            ]);

            $reservacione->update([
                'estatus' => 'pagado',
                'stripe_payment_id' => $charge->id 
            ]);

            return response()->json(['status' => 'success']);

        } catch (IncompletePayment $exception) {
            return response()->json(['message' => 'El pago requiere confirmación 3D Secure.'], 402);
        } catch (\Exception $e) {
            \Log::error("Error en pago Stripe Reservacion #{$reservacione->id}: " . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Busca habitaciones disponibles y calcula el total.
     * Si no encuentra lugar para alguna hora, lanza una Excepción.
     */
    private function procesarDisponibilidad(string $localizacion, string $fecha, array $horariosSolicitados): array
    {
        $totalCalculado = 0;
        $detallesParaInsertar = [];

        foreach ($horariosSolicitados as $hora) {
            $disponible = HabitacionPrecio::select('habitacion_precios.id', 'habitacion_precios.precio')
                ->join('habitaciones', 'habitacion_precios.habitacion_id', '=', 'habitaciones.id')
                ->leftJoin('reservacion_horarios', function($join) use ($fecha) {
                    $join->on('habitacion_precios.id', '=', 'reservacion_horarios.habitacion_precio_id')
                        ->where('reservacion_horarios.fecha', '=', $fecha);
                })
                ->where('habitaciones.ubicacion', $localizacion)
                ->where('habitacion_precios.horario_inicio', $hora)
                ->whereNull('reservacion_horarios.id') 
                ->first();

            if (!$disponible) {
                throw new \Exception("Ya no hay disponibilidad para el horario de las " . substr($hora, 0, 5));
            }

            $totalCalculado += $disponible->precio;
            
            $detallesParaInsertar[] = [
                'habitacion_precio_id' => $disponible->id,
                'fecha'                => $fecha
            ];
        }

        return [
            'total' => $totalCalculado,
            'detalles' => $detallesParaInsertar
        ];
    }
}
