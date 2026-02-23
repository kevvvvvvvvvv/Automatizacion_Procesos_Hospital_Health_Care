<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento; // Asegúrate de que el modelo se llame así
use App\Models\Habitacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

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
        // Si mandas un ID por la URL, buscamos el registro existente para editar/continuar
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
        // Validamos
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id',
            'tipo_servicio' => 'required|string',
        ]);

        // BOTÓN 1: Iniciar Traslado (Crea el registro inicial)
        if ($request->accion === 'iniciar') {
            $mantenimiento = Mantenimiento::create([
                'habitacion_id'    => $request->habitacion_id,
                'tipo_servicio'    => $request->tipo_servicio,
                'comentarios'      => $request->comentarios,
                'user_solicita_id' => auth()->id(),
                'fecha_solicita'   => now(), // Nombre correcto según tu React
            ]);

            return redirect()->route('mantenimiento.create', ['id' => $mantenimiento->id])
                             ->with('success', 'Cronómetro iniciado.');
        }

        // Si por alguna razón llega aquí sin acción, solo guardamos normal
        Mantenimiento::create($request->all());
        return redirect()->route('mantenimiento.index');
    }

    public function update(Request $request, $id)
    {
        $mantenimiento = Mantenimiento::findOrFail($id);

        // ACCIÓN INTERMEDIA: ¡Ya llegué!
        if ($request->accion === 'llegada') {
            $mantenimiento->update([
                'fecha_arregla'    => now(), // Nombre correcto según tu React
                'user_ejecuta_id'  => auth()->id(),
                'duracion_espera'  => now()->diffInSeconds($mantenimiento->fecha_solicita),
            ]);
            return back()->with('success', 'Llegada registrada.');
        }

        // BOTÓN 2: Guardar todas las cosas (Cierre final)
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