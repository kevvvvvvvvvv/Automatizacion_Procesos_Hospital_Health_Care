<?php
namespace App\Http\Controllers;

use App\Models\ReservacionQuirofano;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Habitacion;
use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservacionQuirofanoController extends Controller
{
    
   public function index()
{
    $quirofanos = ReservacionQuirofano::with([
            'user:id,nombre,apellido_paterno', 
            'habitacion:id,identificador', // Cambié 'nombre' por 'identificador' que es el que usas en el Show
            'paciente:id,nombre,apellido_paterno,apellido_materno' // Añadido para que no sea null
        ])
        ->orderBy('fecha', 'desc')
        ->get()
        ->map(function ($res) {
            return [
                'id' => $res->id,
                'fecha' => $res->fecha,
                'localizacion' => $res->localizacion,
                'paciente_nombre' => $res->paciente 
                    ? "{$res->paciente->nombre} {$res->paciente->apellido_paterno}" 
                    : 'N/A',
                'instrumentista' => $res->instrumentista,
                'anestesiologo' => $res->anestesiologo,
                'horarios' => $res->horarios, 
                'user_nombre' => $res->user ? $res->user->nombre : 'N/A',
                'habitacion_nombre' => $res->habitacion ? $res->habitacion->identificador : 'N/A',
                'estancia_id' => $res->estancia_id,
            ];
        });

    // Eliminamos el dd() para que Inertia pueda renderizar la vista
    return Inertia::render('reservacion_quirofano/index', [
        'reservaciones' => $quirofanos
    ]);
}
   public function create(Paciente $paciente, Estancia $estancia)
{
    // 1. Cargamos la relación del paciente dentro de la estancia
    $estancia->load('paciente');

    // 2. Determinamos cuál objeto usar (Prioridad al objeto $paciente de la URL, 
    // sino el de la estancia)
    $pacienteData = null;
    if ($paciente->exists) {
        $pacienteData = $paciente;
    } elseif ($estancia->paciente) {
        $pacienteData = $estancia->paciente;
    }

    // 3. Si sigue siendo null, enviamos un objeto vacío para evitar errores en React
    // o maneja el error si es obligatorio
    
    return Inertia::render('reservacion_quirofano/create', [
        'paciente' => $pacienteData, 
        'estancia' => $estancia,
        'medicos' => \App\Models\User::all()->map(fn($u) => [
            'id' => $u->id,
            'nombre_completo' => "{$u->nombre} {$u->apellido_paterno} {$u->apellido_materno}"
        ]),
        'limitesDinamicos' => Habitacion::where('tipo', 'Quirofano')
            ->selectRaw('ubicacion, count(*) as total')
            ->groupBy('ubicacion')
            ->pluck('total', 'ubicacion')
            ->toArray(),
    ]);
}
    public function store(Request $request, Paciente $paciente, Estancia $estancia)
{
    $validated = $request->validate();

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
   $reservacion = ReservacionQuirofano::create([
        'habitacion_id'    => $habitacionIdAsignada,
        'user_id'          => auth()->id(),
        'estancia_id'      => $estancia->id,
        'paciente'         => $validated['paciente'],
        'tratante'         => $validated['tratante'],
        'procedimiento'    => $validated['procedimiento'],
        'tiempo_estimado'  => $validated['tiempo_estimado'],
        'medico_operacion' => $validated['medico_operacion'],
        'fecha'            => $validated['fecha'],
        'horarios'         => $validated['horarios'],
        'localizacion'     => $validated['localizacion'],
        'comentarios'      => $validated['comentarios'],
        
        // Extraer detalles de los objetos
        'instrumentista'       => $request->instrumentista['detalle'] ?? 'No solicitado',
        'anestesiologo'        => $request->anestesiologo['detalle'] ?? 'No solicitado',
        'insumos_medicamentos' => $request->insumos_med['detalle'] ?? null,
        'esterilizar_detalle'  => $request->esterilizar['detalle'] ?? null,
        'rayosx_detalle'       => $request->rayosx['detalle'] ?? null,
        'patologico_detalle'   => $request->patologico['detalle'] ?? null,
    ]);

    return redirect()->route('quirofanos.show', $reservacion->id);
}
}