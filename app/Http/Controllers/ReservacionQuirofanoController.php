<?php

namespace App\Http\Controllers;

use App\Models\ReservacionQuirofano;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Habitacion;
use App\Models\Estancia;
use App\Http\Requests\ReservacionQuirofanoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservacionQuirofanoController extends Controller
{
    public function index()
    {
        $reservaciones = ReservacionQuirofano::with([
                'user:id,nombre,apellido_paterno',
                'habitacion:id,identificador'
            ])
            ->orderBy('fecha', 'desc')
            ->get()
            ->map(fn ($res) => [
                'id' => $res->id,
                'fecha' => $res->fecha,
                'localizacion' => $res->localizacion,
                // Como en la migración 'paciente' es un string, lo usamos directo
                'paciente_nombre' => $res->paciente ?? 'N/A', 
                'instrumentista' => $res->instrumentista,
                'anestesiologo' => $res->anestesiologo,
                'horarios' => $res->horarios,
                'user_nombre' => $res->user?->nombre ?? 'N/A',
                'habitacion_nombre' => $res->habitacion?->identificador ?? 'N/A',
                'estancia_id' => $res->estancia_id,
            ]);

        return Inertia::render('reservacion_quirofano/index', [
            'reservaciones' => $reservaciones
        ]);
    }

    public function create(Request $request)
    {
        $paciente = Paciente::find($request->paciente);
        $estancia = Estancia::find($request->estancia);
        $pacienteData = $paciente ?: ($estancia?->paciente);

        return Inertia::render('reservacion_quirofano/create', [
            'paciente' => $pacienteData,
            'estancia' => $estancia,
            'medicos' => User::select('id', 'nombre', 'apellido_paterno', 'apellido_materno')
                ->get()
                ->map(fn ($u) => [
                    'id' => $u->id,
                    'nombre_completo' => "{$u->nombre} {$u->apellido_paterno} {$u->apellido_materno}"
                ]),
            'limitesDinamicos' => Habitacion::where('tipo', 'Quirofano')
                ->selectRaw('ubicacion, COUNT(*) as total')
                ->groupBy('ubicacion')
                ->pluck('total', 'ubicacion')
                ->toArray(),
        ]);
    }

   public function store(ReservacionQuirofanoRequest $request)
{
    $validated = $request->validated();
    $validated['user_id'] = auth()->id();
    
    // Si tienes una lógica para asignar la habitación por la localización:
    // $validated['habitacion_id'] = ... 

    ReservacionQuirofano::create($validated);

    return redirect()->route('quirofanos.index')->with('success', 'Reservación creada.');
}
}