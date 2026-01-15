<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\NotaPostoperatoria;
use App\Models\notasEvoluciones;
use App\Models\Estancia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

use Redirect;
use App\Http\Requests\HabitacionRequest;

class HabitacionController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar habitaciones', only: ['index', 'show']),
            new Middleware($permission . ':crear habitaciones', only: ['create', 'store']),
            new Middleware($permission . ':editar habitaciones', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar habitaciones', only: ['destroy']),
        ];
    }
    public function create(){
        return Inertia::render('habitaciones/create', [
            'habitacion' => null,
        ]);
    }
    public function store(HabitacionRequest $request){
        Habitacion::create($request->validated());
        return Redirect::route('habitaciones.index')
        ->with('Succes', 'Habitación resgitrada');

    }
  



    public function show(Habitacion $habitacione)
    {
        // 1. Cargamos la estancia activa y sus relaciones básicas
        // Usamos 'estanciaActiva' que definiste en el modelo Habitacion
        $habitacione->load(['estanciaActiva.paciente', 'estanciaActiva.formularioInstancias.user']);
        
        $estancia = $habitacione->estanciaActiva;
        $paciente = $estancia ? $estancia->paciente : null;
        
        $nota = null;
        $checklistInicial = [];

        if ($estancia) {
            // 2. Utilizamos la misma lógica del controlador de enfermería
            $nota = $this->obtenerListaTratamiento($estancia);

            // 3. Si hay nota, extraemos el checklist
            if ($nota) {
                // Cargamos los items para que no lleguen vacíos
                $nota->load('checklistItems');
                $checklistInicial = $nota->checklistItems->where('is_completed', true)->values();
            }
        }

        return Inertia::render('habitaciones/showdetalles', [
            'habitacion' => $habitacione,
            'estancia'   => $estancia,
            'paciente'   => $paciente,
            'nota'       => $nota,
            'checklistInicial' => $checklistInicial,
        ]);
    }

    /**
     * Replicamos la lógica para obtener la nota más reciente
     */
    private function obtenerListaTratamiento(Estancia $estancia)
    {
        $notaPostoperatoria = $estancia->notasPostoperatorias()->latest()->first();
        $notaEvolucion = $estancia->notasEvoluciones()->latest()->first();

        $nota = null;

        if ($notaPostoperatoria && $notaEvolucion) {
            $nota = $notaPostoperatoria->created_at > $notaEvolucion->created_at 
                    ? $notaPostoperatoria 
                    : $notaEvolucion;
        } elseif ($notaPostoperatoria) {
            $nota = $notaPostoperatoria;
        } else {
            $nota = $notaEvolucion;
        }

        return $nota;
    }

    public function update(HabitacionRequest $request, Habitacion $habitacione){
        $habitacione->update($request->validated());

        return Redirect::route('habitaciones.index')
        ->with('Success', 'Habitacion actualizada');
    }
    public function edit(Habitacion $habitacione){
        return Inertia::render('habitaciones/create', [
            'habitacion' => $habitacione,
        ]);
    }
    public function index()
    {
        $habitaciones = Habitacion::with('estanciaActiva.paciente')->get();
        return Inertia::render('habitaciones/index',['habitaciones' => $habitaciones]);
    }
}
