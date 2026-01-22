<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\FamiliarResponsable;  
use App\Models\Estancia;
use Inertia\Inertia;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curp' => 'required|string|max:18|unique:pacientes,curp',
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'sexo' => 'required|string|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'calle' => 'required|string|max:100',
            'numero_exterior' => 'required|string|max:50',
            'numero_interior' => 'nullable|string|max:50',
            'colonia' => 'required|string|max:100',
            'municipio' => 'required|string|max:100',
            'estado' => 'required|string|max:100',
            'pais' => 'required|string|max:100',
            'cp' => 'required|string|max:10',
            'telefono' => 'required|string|max:20',
            'estado_civil' => 'required|string|in:Soltero(a),Casado(a),Divorciado(a),Viudo(a),Union libre',
            'ocupacion' => 'required|string|max:100',
            'lugar_origen' => 'required|string|max:100',
            'nombre_padre' => 'nullable|string|max:100',
            'nombre_madre' => 'nullable|string|max:100',

            'responsables' => 'nullable|array',
            'responsables.*.nombre_completo' => 'required|string|max:100',
            'responsables.*.parentesco' => 'required|string|max:100',
        ]);

        return DB::transaction(function () use ($validated) {
            try {
                $pacienteData = Arr::except($validated, ['responsables']);
                
                $paciente = Paciente::create($pacienteData);
                if (!empty($validated['responsables'])) {
                    $paciente->familiarResponsables()->createMany($validated['responsables']);
                }
                return redirect()->route('pacientes.index')
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

public function update(Request $request, Paciente $paciente)
{

    $validatedPaciente = $request->validate([
        'curp' => ['required', 'string', 'max:18', 'unique:pacientes,curp,' . $paciente->id],
        'nombre' => 'required|string|max:100',
        'apellido_paterno' => 'required|string|max:100',
        'apellido_materno' => 'required|string|max:100',
        'sexo' => 'required|string|in:Masculino,Femenino',
        'fecha_nacimiento' => 'required|date',
        'calle' => 'required|string|max:100',
        'numero_exterior' => 'required|string|max:50',
        'numero_interior' => 'nullable|string|max:50',
        'colonia' => 'required|string|max:100',
        'municipio' => 'required|string|max:100',
        'estado' => 'required|string|max:100',
        'pais' => 'required|string|max:100',
        'cp' => 'required|string|max:10',
        'telefono' => 'required|string|max:20',
        'estado_civil' => 'required|string|in:Soltero(a),Casado(a),Divorciado(a),Viudo(a),Union libre',
        'ocupacion' => 'required|string|max:100',
        'lugar_origen' => 'required|string|max:100',
        'nombre_padre' => 'nullable|string|max:100',
        'nombre_madre' => 'nullable|string|max:100',
    
        'responsables' => 'nullable|array', 
        'responsables.*.nombre_completo' => 'required|string|max:100',
        'responsables.*.parentesco' => 'required|string|max:100',
    ]);


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
