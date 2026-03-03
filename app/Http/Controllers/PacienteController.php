<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\FamiliarResponsable;  
use App\Models\Estancia;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;


class PacienteController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar pacientes', only: ['index', 'show']),
            new Middleware($permission . ':crear pacientes', only: ['create', 'store']),
            new Middleware($permission . ':editar pacientes', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar pacientes', only: ['destroy']),
        ];
    }

    public function index()
    {
        $pacientes = Paciente::all();
        return Inertia::render('pacientes/index', ['pacientes' => $pacientes]);
    }

    public function create()
    {
        return Inertia::render('pacientes/create');
    }
 
    public function store(PacienteRequest $request)
    { 
        $validated = $request->validated();
        
        return DB::transaction(function () use ($validated) {
            try {
                $pacienteData = Arr::except($validated, ['responsables']);
                $paciente = Paciente::create($pacienteData);
                if (!empty($validated['responsables'])) {
                    $paciente->familiarResponsables()->createMany($validated['responsables']);
                } return redirect()->route('pacientes.index')
                    ->with('success', 'Paciente registrado correctamente.');
            } catch (\Exception $e) {
                \Log::error('Error creando paciente: ' . $e->getMessage());
                return back()->with('error', 'Ocurrió un error al guardar los datos. Por favor intente de nuevo.');
            }
        });
    }
    

    public function show(Paciente $paciente)
    {
        $paciente->load(['estancias' => function ($query) {
                $query->orderBy('id', 'asc');
            },
            'estancias.creator']);
        return Inertia::render('pacientes/show', ['paciente' => $paciente]);
    }

    public function edit(Paciente $paciente)
    {
        $paciente->load('familiarResponsables');
        return Inertia::render('pacientes/edit', ['paciente' => $paciente]);
    }

    public function update(PacienteRequest $request, Paciente $paciente)
    {

        $validatedPaciente = $request->validated();


        \DB::transaction(function () use ($paciente, $validatedPaciente, $request) {
    
            $datosPaciente = \Illuminate\Support\Arr::except($validatedPaciente, ['responsables']);
            $paciente->update($datosPaciente);
            $paciente->familiarResponsables()->delete();
            if ($request->has('responsables') && !empty($request->responsables)) {
                $paciente->familiarResponsables()->createMany($request->responsables);
            }
        });

        return redirect()->route('pacientes.index')
                        ->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
