<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Habitacion;
use App\Models\ReservacionHorario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;

use App\Http\Requests\ReservacionRequest;

class ReservacionController extends Controller
{

    public function index()
    {
       $reservaciones = Reservacion::with([
        'horarios.habitacion',
        'user:id,nombre' // Importante cargar el ID y el nombre del usuario
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
    //dd($reservacione->ToArray());
    return Inertia::render('reservacion/show', [
        'reservacion' => $reservacione,
        'user'        => $reservacione->user, // Asegúrate de que se llame 'user'
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
    // Cargamos las relaciones
    $reservacion->load('horarios');

    $limitesPorSede = Habitacion::where('tipo', 'Consultorio')
        ->select('ubicacion', DB::raw('count(*) as total'))
        ->groupBy('ubicacion')
        ->pluck('total', 'ubicacion');

    $ocupacionActual = ReservacionHorario::join('habitaciones', 'reservacion_horarios.habitacion_id', '=', 'habitaciones.id')
        ->select('habitaciones.ubicacion', 'reservacion_horarios.fecha_hora', DB::raw('count(*) as ocupados'))
        ->where('reservacion_horarios.reservacion_id', '!=', $reservacion->id) // Fundamental para que no se bloquee a sí mismo
        ->groupBy('habitaciones.ubicacion', 'reservacion_horarios.fecha_hora')
        ->get()
        ->mapWithKeys(function ($item) {
            $fechaFormateada = \Carbon\Carbon::parse($item->fecha_hora)->format('Y-m-d H:i:s');
            return [$item->ubicacion . '|' . $fechaFormateada => $item->ocupados];
        });

    // 3. PASO CLAVE: Formatear los horarios que el usuario ya tiene seleccionados
    $horariosYaElegidos = $reservacion->horarios->map(function($h) {
        return \Carbon\Carbon::parse($h->fecha_hora)->format('Y-m-d H:i:s');
    });

    return Inertia::render('reservacion/create', [
        'reservacion' => $reservacion,
        'limitesDinamicos' => $limitesPorSede,
        'ocupacionActual' => $ocupacionActual,
        'horariosSeleccionados' => $horariosYaElegidos // Esto inicializa los botones azules
    ]);
}
public function update(ReservacionRequest $request, Reservacion $reservacion)
{
    $data = $request->validated();
    DB::beginTransaction();

    try {

        // 1. Actualizar datos básicos
        $reservacion->update([
            'localizacion' => $data['localizacion'],
            'fecha' => $data['fecha'],
            'horas' => count($data['horarios']),
        ]);

        // 2. Limpiar horarios anteriores para reasignar
        $reservacion->horarios()->delete();

        // 3. Reasignar (igual que en store)
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
}
