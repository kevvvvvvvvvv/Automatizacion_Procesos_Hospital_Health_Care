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

class ReservacionController extends Controller
{

    public function index()
    {
       $reservaciones = Reservacion::with([
            'horarios.habitacion',
            'user:id,nombre' 
        ])

    ->orderBy('fecha', 'desc')
    ->get();

    return Inertia::render('reservacion/index', [
        'reservaciones' => $reservaciones
    ]);
    }

    public function show(Reservacion $reservacione)
    {

        $reservacione->load(['user', 'horarios.habitacion']);
        return Inertia::render('reservacion/show', [
            'reservacion' => $reservacione,
            'user'        => $reservacione->user, 
            'horarios'    => $reservacione->horarios,
        ]);
    }
   
    public function create()
    {
        $limitesPorSede = Habitacion::where('tipo', 'Consultorio')
            ->select('ubicacion', DB::raw('count(*) as total'))
            ->groupBy('ubicacion')
            ->get()
            ->pluck('total', 'ubicacion');


            $ocupacionActual = ReservacionHorario::join('habitaciones', 'reservacion_horarios.habitacion_id', '=', 'habitaciones.id')
                ->select(
                    'habitaciones.ubicacion', 
                    'reservacion_horarios.fecha_hora', 
                    DB::raw('count(*) as ocupados')
                )
                ->groupBy('habitaciones.ubicacion', 'reservacion_horarios.fecha_hora')
                ->get()
                ->mapWithKeys(function ($item) {
                    $fechaFormateada = \Carbon\Carbon::parse($item->fecha_hora)->format('Y-m-d H:i:s');
                    return [$item->ubicacion . '|' . $fechaFormateada => $item->ocupados];
                });

        return Inertia::render('reservacion/create', [
            'limitesDinamicos' => $limitesPorSede,
            'ocupacionActual'  => $ocupacionActual
        ]);
    }

    public function store(ReservacionRequest $request)
    {

        //dd($request->toArray());
        $data = $request->validated();
        DB::beginTransaction();
    

        try {

            $horarios = collect($data['horarios'])
                ->map(fn ($h) => Carbon::parse($h)->format('Y-m-d H:i:s'))
                ->toArray();
            $sedeBusqueda = $data['localizacion']; 

            $reservacion = Reservacion::create([
            'localizacion' => $data['localizacion'],
            'fecha'        => $data['fecha'],
            'horas'        => count($horarios),
            'user_id'      => Auth::id(),
            'estatus'      => 'pendiente', 
        ]);


            foreach ($horarios as $fechaHora) {
                $habitacionLibre = Habitacion::where('tipo', 'Consultorio')
                    ->where('ubicacion', $sedeBusqueda) 
                    ->whereDoesntHave('horarios', function ($query) use ($fechaHora) {
                        $query->where('fecha_hora', $fechaHora);
                    })
                    ->first();

                if (!$habitacionLibre) {
                    throw new \Exception("No hay consultorios disponibles en $sedeBusqueda para las " . Carbon::parse($fechaHora)->format('H:i'));
                }

                ReservacionHorario::create([
                    'reservacion_id' => $reservacion->id,
                    'habitacion_id'  => $habitacionLibre->id,
                    'fecha_hora'     => $fechaHora,
                ]);
            }

            DB::commit();
            return redirect()->route('reservaciones.show', $reservacion->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(Reservacion $reservacion)
    {
        $reservacion->load('horarios');

        $limitesPorSede = Habitacion::where('tipo', 'Consultorio')
            ->select('ubicacion', DB::raw('count(*) as total'))
            ->groupBy('ubicacion')
            ->pluck('total', 'ubicacion');

        $ocupacionActual = ReservacionHorario::join('habitaciones', 'reservacion_horarios.habitacion_id', '=', 'habitaciones.id')
            ->select('habitaciones.ubicacion', 'reservacion_horarios.fecha_hora', DB::raw('count(*) as ocupados'))
            ->where('reservacion_horarios.reservacion_id', '!=', $reservacion->id) 
            ->groupBy('habitaciones.ubicacion', 'reservacion_horarios.fecha_hora')
            ->get()
            ->mapWithKeys(function ($item) {
                $fechaFormateada = \Carbon\Carbon::parse($item->fecha_hora)->format('Y-m-d H:i:s');
                return [$item->ubicacion . '|' . $fechaFormateada => $item->ocupados];
            });

        $horariosYaElegidos = $reservacion->horarios->map(function($h) {
            return \Carbon\Carbon::parse($h->fecha_hora)->format('Y-m-d H:i:s');
        });

        return Inertia::render('reservacion/create', [
            'reservacion' => $reservacion,
            'limitesDinamicos' => $limitesPorSede,
            'ocupacionActual' => $ocupacionActual,
            'horariosSeleccionados' => $horariosYaElegidos 
        ]);
    }
    public function update(ReservacionRequest $request, Reservacion $reservacion)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            $reservacion->update([
                'localizacion' => $data['localizacion'],
                'fecha' => $data['fecha'],
                'horas' => count($data['horarios']),
            ]);

            $reservacion->horarios()->delete();

            foreach ($request->horarios as $nuevoHorario) {
                $habitacionLibre = Habitacion::where('tipo', 'Consultorio')
                    ->where('ubicacion', $data['localizacion'])
                    ->whereDoesntHave('horarios', function ($query) use ($fechaHora) {
                        $query->where('fecha_hora', $fechaHora);
                    })
                    ->first();

                if (!$habitacionLibre) {
                    throw new \Exception("Ya no hay disponibilidad para el horario seleccionado.");
                }

                ReservacionHorario::create([
                    'reservacion_id' => $reservacion->id,
                    'habitacion_id' => $habitacionLibre->id,
                    'fecha_hora' => $fechaHora,
                ]);
            }

            DB::commit();
            return redirect()->route('reservaciones.index')->with('success', 'Reservación actualizada.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function pagar(Request $request, Reservacion $reservacione)
    {
        if ($reservacione->user_id !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($reservacione->estatus === 'pagado') {
            return response()->json(['message' => 'Ya está pagada'], 400);
        }

        $request->validate(['payment_method' => 'required|string']);

        try {
            $cantidadHoras = $reservacione->horas; 
            $precioPorHora = 100; 
            $totalCentavos = ($cantidadHoras * $precioPorHora) * 100; 

            $user = Auth::user();

            $charge = $user->charge($totalCentavos, $request->input('payment_method'), [
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
            return response()->json(['message' => 'El pago requiere confirmación adicional.'], 402);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
