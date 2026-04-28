<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservacionQuirofanoRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

use App\Models\Reservacion\ReservacionQuirofano\ReservacionQuirofano;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Habitacion\Habitacion;
use App\Models\Estancia;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class ReservacionQuirofanoController extends Controller
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar reservaciones quirofanos', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear reservaciones quirofanos', only: ['create', 'store']),
            new Middleware($permission . ':eliminar reservaciones quirofanos', only: ['destroy']),
            new Middleware($permission . ':crear reservaciones quirofanos', only: ['create', 'store', 'edit', 'update']),
            ];
    }

    public function index(Request $request)
    {
        $fechaIso = $request->input('fecha_filtro');

        $query = ReservacionQuirofano::with([
            'user:id,nombre,apellido_paterno',
            'habitacion:id,identificador',
            'medicoOperacionRel:id,nombre,apellido_paterno'
        ]);

        if ($fechaIso) {
            $fechaLimpia = Carbon::parse($fechaIso)->format('Y-m-d');
            $query->whereDate('fecha', $fechaLimpia);
        }

        $reservaciones = $query->orderBy('fecha', 'desc')
            ->get()
            ->map(fn ($res) => [
                'id' => $res->id,
                'fecha' => $res->fecha,
                'localizacion' => $res->localizacion,
                'status' => $res->status,
                'paciente_nombre' => $res->paciente ?? 'N/A', 
                'instrumentista' => $res->instrumentista,
                'anestesiologo' => $res->anestesiologo,
                'horarios' => $res->horarios,
                'comentarios' => $res->comentarios,
                'procedimiento' => $res->procedimiento,
                'medico_operacion' => $res->medicoOperacionRel 
                ? "{$res->medicoOperacionRel->nombre} {$res->medicoOperacionRel->apellido_paterno}" 
                : 'No asignado',
                'user_nombre' => $res->user?->nombre ?? 'N/A',
                'habitacion_nombre' => $res->habitacion?->identificador ?? 'N/A',
                'estancia_id' => $res->estancia_id,
            ]);

        return Inertia::render('reservacion_quirofano/index', [
            'reservaciones' => $reservaciones,
            'filtros' => [
                    'fecha_filtro' => $fechaIso ? Carbon::parse($fechaIso)->format('Y-m-d') : ''
                ],
        ]);
    }

    public function create(Request $request)
    {
        $paciente = Paciente::find($request->paciente);
        $estancia = Estancia::find($request->estancia);
        $pacienteData = $paciente ?: ($estancia?->paciente);
        $fechaSeleccionada = $request->fecha ?? now()->toDateString(); 

        $horariosOcupados = ReservacionQuirofano::where('fecha', $fechaSeleccionada)
        ->where('status', '!=', 'cancelada')
        ->get()
        ->pluck('horarios')
        ->flatten()
        ->toArray();

        return Inertia::render('reservacion_quirofano/create', [
            'paciente' => $pacienteData,
            'estancia' => $estancia,
            'horariosOcupados' => $horariosOcupados,
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
            $reservacion->user_id          = Auth::id();
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
            $reservacion->status        = $request->status ?? 'pendiente';
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
    public function edit(ReservacionQuirofano $quirofano)
    {
        $horariosOcupados = ReservacionQuirofano::where('fecha', $quirofano->fecha)
        ->where('status', '!=', 'cancelada')
        ->where('id', '!=', $quirofano->id) 
        ->get()
        ->pluck('horarios')
        ->flatten()
        ->toArray();
        //  dd($horariosOcupados);
        //dd($quirofano->toArray());
        return Inertia::render('reservacion_quirofano/edit', [
            'quirofano' => $quirofano,
            'horariosOcupados' => $horariosOcupados,
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

   public function update(ReservacionQuirofanoRequest $request, ReservacionQuirofano $quirofano)
{
    $data = $request->validated();
    $LOCALIZACION = 'Plan de Ayutla';

    // 1. Validar disponibilidad solo si no se cancela
    if ($request->status !== 'cancelada') {
        $quirofanos = Habitacion::where('tipo', 'Quirofano')
            ->where('ubicacion', $LOCALIZACION)
            ->pluck('id');
            
        $habitacionAsignada = null;

        foreach ($quirofanos as $quirofanoId) {
            $ocupado = ReservacionQuirofano::where('habitacion_id', $quirofanoId)
                ->where('id', '!=', $quirofano->id) 
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
        $quirofano->habitacion_id = $habitacionAsignada;
    }

    // 2. Mapear los campos manualmente desde el request para asegurar que entren como null si es necesario
    $quirofano->fill($data); // Esto llena los campos validados del Request
    
    // Forzamos los valores del request (que ya transformamos en React a null si no están activos)
    $quirofano->instrumentista = $request->instrumentista;
    $quirofano->anestesiologo = $request->anestesiologo;
    $quirofano->insumos_medicamentos = $request->insumos_medicamentos;
    $quirofano->esterilizar_detalle = $request->esterilizar_detalle;
    $quirofano->rayosx_detalle = $request->rayosx_detalle;
    $quirofano->patologico_detalle = $request->patologico_detalle;
    $quirofano->laparoscopia_detalle = $request->laparoscopia_detalle;
    
    $quirofano->status = $request->status;
    $quirofano->motivo_cancelacion = ($request->status === 'cancelada') ? $request->motivo_cancelacion : null;

    $quirofano->save();

    return redirect()->route('quirofanos.index')->with('success', 'Actualizado correctamente.');
}

    public function show(ReservacionQuirofano $quirofano)
    {
        $quirofano->load(['user', 'habitacion','medicoTratante','medicoOperacionRel']);
        //dd($quirofano->toArray());

        return Inertia::render('reservacion_quirofano/show', [
            'quirofano' => $quirofano, 
            'user'      => $quirofano->user,
            'horarios'  => $quirofano->horarios ?? [],
        ]);
    }
    
};