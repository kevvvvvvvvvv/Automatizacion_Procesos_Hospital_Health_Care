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
    $data = $request->validated();
    $LOCALIZACION = 'Plan de Ayutla';
    //dd($data->toArray());
    try {
        $quirofanos = Habitacion::where('tipo', 'Quirofano')->where('ubicacion', $LOCALIZACION)->pluck('id');
        $habitacionAsignada = null;

        foreach ($quirofanos as $quirofanoId) {
            $ocupado = ReservacionQuirofano::where('habitacion_id', $quirofanoId)
                ->where('fecha', $data['fecha'])
                ->where(function ($query) use ($data) {
                    foreach ($data['horarios'] as $hora) {
                        $query->orWhereJsonContains('horarios', $hora);
                    }
                })->exists();

            if (!$ocupado) {
                $habitacionAsignada = $quirofanoId;
                break;
            }
        }

        if (!$habitacionAsignada) {
            return back()->withErrors(['horarios' => 'No hay quirófanos disponibles.']);
        }

        $reservacion = new ReservacionQuirofano();
        
        $reservacion->habitacion_id    = $habitacionAsignada;
        $reservacion->user_id          = auth()->id();
        $reservacion->localizacion     = $LOCALIZACION;
        
        $reservacion->paciente         = $request->paciente;
        //$reservacion->paciente_id      = $request->paciente_id;
        $reservacion->estancia_id      = $request->estancia_id;
        $reservacion->procedimiento    = $request->procedimiento;
        $reservacion->tratante         = $request->tratante;
        $reservacion->medico_operacion = $request->medico_operacion;
        $reservacion->tiempo_estimado  = $request->tiempo_estimado;
        $reservacion->fecha            = $request->fecha;
        $reservacion->horarios         = $request->horarios;
        $reservacion->comentarios      = $request->comentarios;

        // --- REVISA SI ESTOS NOMBRES EXISTEN EN TU MIGRACIÓN ---
        $reservacion->instrumentista        = $request->instrumentista;
        $reservacion->anestesiologo         = $request->anestesiologo;
        $reservacion->insumos_medicamentos  = $request->insumos_medicamentos;
        $reservacion->esterilizar_detalle   = $request->esterilizar_detalle;
        $reservacion->rayosx_detalle        = $request->rayosx_detalle;
        $reservacion->patologico_detalle    = $request->patologico_detalle;
        $reservacion->laparoscopia_detalle  = $request->laparoscopia_detalle;

        $reservacion->save();

        return redirect()->route('quirofanos.index')->with('success', 'Reservación creada.');

    } catch (\Exception $e) {
        return back()->withErrors([
            'error' => 'Error de Base de Datos: ' . $e->getMessage()
        ]);
    }
}


public function show(ReservacionQuirofano $quirofano)
{
    $quirofano->load(['user', 'habitacion']);

    return Inertia::render('reservacion_quirofano/show', [
        'quirofano' => $quirofano, 
        'user'      => $quirofano->user,
        'horarios'  => $quirofano->horarios ?? [],
    ]);
}
};