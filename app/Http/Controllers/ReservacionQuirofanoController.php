<?php
namespace App\Http\Controllers;

use App\Models\ReservacionQuirofano;
use App\Models\Paciente;
use App\Models\Habitacion;
use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservacionQuirofanoController extends Controller
{
    
     public function index()
{
    $reservaciones = ReservacionQuirofano::with(['user:id,name', 'habitacion:id,nombre'])
        ->orderBy('fecha', 'desc')
        ->get()
        ->map(function ($res) {
           return [
                'id' => $res->id,
                'fecha' => $res->fecha,
                'localizacion' => $res->localizacion,
                'instrumentista' => $res->instrumentista,
                'anestesiologo' => $res->anestesiologo,
                // Si guardaste los horarios como JSON en la BD, Laravel los convierte en array automáticamente
                'horarios' => $res->horarios, 
                'user' => $res->user,
                'habitacion' => $res->habitacion,
            ];
        });

    // 3. Retornamos la vista de Inertia con los datos
    return Inertia::render('reservacion_quirofano/index', [
        'reservaciones' => $reservaciones
    ]);
    }
    public function create(Paciente $paciente, Estancia $estancia)
    {
        // 1. Cargamos explícitamente el paciente desde la estancia si no viene inyectado
        $estancia->load('paciente');
        $pacienteData = $paciente->exists ? $paciente : $estancia->paciente;

        // 2. Límites dinámicos basados en la ubicación de las habitaciones
        $limitesDinamicos = Habitacion::where('tipo', 'Quirofano')
            ->selectRaw('ubicacion, count(*) as total')
            ->groupBy('ubicacion')
            ->pluck('total', 'ubicacion')
            ->toArray();

        return Inertia::render('reservacion_quirofano/create', [
            'paciente' => $pacienteData,
            'estancia' => $estancia,
            'limitesDinamicos' => $limitesDinamicos,
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
{
    $validated = $request->validate([
        'procedimiento'     => 'required|string',
        'tiempo_estimado'   => 'required|string',
        'medico_operacion'  => 'required|string',
        'instrumentista'    => 'required|string',
        'anestesiologo'     => 'required|string',
        'localizacion'      => 'required|string', // "Plan de ayutla" o "Díaz Ordaz"
        'fecha'             => 'required|date',
        'horarios'          => 'required|array',
    ]);

    // LÓGICA DE ASIGNACIÓN AUTOMÁTICA
    // 1. Obtener IDs de quirófanos en esa ubicación
    $quirofanosEnUbicacion = Habitacion::where('tipo', 'Quirofano')
        ->where('ubicacion', $validated['localizacion'])
        ->pluck('id');

    // 2. Buscar cuál de esos NO está ocupado en esos horarios
    $habitacionIdAsignada = null;

    foreach ($quirofanosEnUbicacion as $id) {
        $estaOcupado = ReservacionQuirofano::where('habitacion_id', $id)
            ->where('fecha', $validated['fecha'])
            // Verificamos si hay traslape en el JSON de horarios
            ->where(function($query) use ($validated) {
                foreach ($validated['horarios'] as $hora) {
                    $query->orWhereJsonContains('horarios', $hora);
                }
            })->exists();

        if (!$estaOcupado) {
            $habitacionIdAsignada = $id;
            break; // Encontramos uno libre, lo asignamos
        }
    }

    if (!$habitacionIdAsignada) {
        return back()->withErrors(['error' => 'No hay quirófanos disponibles en esa ubicación para el horario seleccionado.']);
    }

    // 3. Crear la reservación con el ID encontrado automáticamente
    ReservacionQuirofano::create([
        ...$validated,
        'habitacion_id' => $habitacionIdAsignada,
        'estancia_id'   => $estancia->id,
        'user_id'       => auth()->id(),
        'insumos_medicamentos' => $request->insumos_med['detalle'] ?? null,
        'esterilizar_detalle'  => $request->esterilizar['detalle'] ?? null,
        'rayosx_detalle'       => $request->rayosx['detalle'] ?? null,
        'patologico_detalle'   => $request->patologico['detalle'] ?? null,
    ]);

    return redirect()->route('quirofanos.index')->with('success', 'Quirófano asignado automáticamente.');
}
}