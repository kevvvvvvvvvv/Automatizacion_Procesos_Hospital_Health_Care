<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\Mantenimiento\Mantenimiento;
use App\Models\Habitacion\Habitacion;

class MantenimientoController extends Controller
{
    public function index()
    {
        return Inertia::render('Mantenimiento/index', [
        'mantenimientos' => Mantenimiento::latest()->take(10)->get(),
        'status' => session('success'),
    ]);
    }

    public function create(Request $request)
    {
        $mantenimiento = null;
        if ($request->has('id')) {
            $mantenimiento = Mantenimiento::find($request->id);
        }

        return Inertia::render('Mantenimiento/create', [
            'habitaciones' => Habitacion::all(),
            'mantenimiento' => $mantenimiento,
            'habitacion_id' => $request->query('habitacion_id'),
            'tipo' => $request->query('tipo', 'General')
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'tipo_servicio' => 'required|string',
        ]);

        if ($request->accion === 'iniciar') {
            $mantenimiento = Mantenimiento::create([
                'habitacion_id'    => $request->habitacion_id,
                'tipo_servicio'    => $request->tipo_servicio,
                'comentarios'      => $request->comentarios,
                'user_solicita_id' => Auth::id(),
                'fecha_solicita'   => now(), 
            ]);

            return redirect()->route('mantenimiento.create', ['id' => $mantenimiento->id])
                             ->with('success', 'Cronómetro iniciado.');
        }

        Mantenimiento::create($request->all());
        return redirect()->route('mantenimiento.index');
    }

    public function update(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);

        if ($request->accion === 'llegada') {
            $mantenimiento->update([
                'fecha_arregla'    => now(), 
                'user_ejecuta_id'  => Auth::id(),
                'duracion_espera'  => now()->diffInSeconds($mantenimiento->fecha_solicita),
            ]);
            return back()->with('success', 'Llegada registrada.');
        }

        $mantenimiento->update([
            'resultado_aceptado' => $request->resultado_aceptado,
            'observaciones'      => $request->observaciones,
            'comentarios'        => $request->comentarios,
            'duracion_actividad' => $mantenimiento->fecha_arregla 
                                    ? now()->diffInSeconds($mantenimiento->fecha_arregla) 
                                    : 0,
        ]);

        return redirect()->route('mantenimiento.index')->with('success', 'Reporte guardado con éxito.');
    }
   public function show($id)
{
    return Inertia::render('Mantenimiento/show', [
        'mantenimiento' => Mantenimiento::findOrFail($id)
    ]);
}
}