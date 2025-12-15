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
    /* =========================
       INDEX
    ========================= */
    public function index()
    {
        $reservaciones = Reservacion::with([
            'horarios.habitacion:id,identificador,tipo'
        ])
        ->orderBy('fecha', 'desc')
        ->get();

        return Inertia::render('reservacion/index', [
            'reservaciones' => $reservaciones
        ]);
    }

    /* =========================
       CREATE
    ========================= */
    public function create()
    {
        return Inertia::render('reservacion/create');
    }

    /* =========================
       STORE
    ========================= */

public function store(ReservacionRequest $request)
{
    $data = $request->validated();
//    dd($request->toArray());
    DB::beginTransaction();

    try {
        $horarios = collect($data['horarios'])
            ->map(fn ($h) => Carbon::parse($h)->format('Y-m-d H:i:s'))  
            ->toArray();
        if (empty($horarios)) {
            throw new \Exception('Debe seleccionar al menos un horario válido.');
        }
        $consultorio = Habitacion::where('tipo', 'Consultorio') 
            ->orderBy('id')
            ->first();
        
        if (!$consultorio) {
            throw new \Exception('No hay consultorios disponibles para la reservación.');
        }

        $reservacion = Reservacion::create([
            'localizacion' => $data['localizacion'],
            'fecha'        => $data['fecha'],
            'horas'        => count($horarios),
            'user_id'      => Auth::id(),]);

        foreach ($horarios as $fechaHora) {
            ReservacionHorario::create([
                'reservacion_id' => $reservacion->id, 
                'habitacion_id'  => $consultorio->id,
                'fecha_hora'     => $fechaHora,
            ]);
        }

        DB::commit();

        return redirect()
            ->route('reservaciones.index')
            ->with('success', 'Reservación creada correctamente');

    } catch (\Throwable $e) {

        DB::rollBack();

        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }
}

}
