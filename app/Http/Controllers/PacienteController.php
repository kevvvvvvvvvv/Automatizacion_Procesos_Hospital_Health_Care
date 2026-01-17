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
        return \DB::transaction(function() use ($request) {
            try {
                $validatedData = $request->validate([
                    'paciente.curp' => 'required|string|max:18|unique:pacientes,curp',
                    'paciente.nombre' => 'required|string|max:100',
                    'paciente.apellido_paterno' => 'required|string|max:100',
                    'paciente.apellido_materno' => 'required|string|max:100',
                    'paciente.sexo' => 'required|string|in:Masculino,Femenino',
                    'paciente.fecha_nacimiento' => 'required|date',
                    'paciente.calle' => 'required|string|max:100',
                    'paciente.numero_exterior' => 'required|string|max:50',
                    'paciente.numero_interior' => 'nullable|string|max:50',
                    'paciente.colonia' => 'required|string|max:100',
                    'paciente.municipio' => 'required|string|max:100',
                    'paciente.estado' => 'required|string|max:100',
                    'paciente.pais' => 'required|string|max:100',
                    'paciente.cp' => 'required|string|max:10',
                    'paciente.telefono' => 'required|string|max:20',
                    'paciente.estado_civil' => 'required|string|in:Soltero(a),Casado(a),Divorciado(a),Viudo(a),Union libre',
                    'paciente.ocupacion' => 'required|string|max:100',
                    'paciente.lugar_origen' => 'required|string|max:100',
                    'paciente.nombre_padre' => 'nullable|string|max:100',
                    'paciente.nombre_madre' => 'nullable|string|max:100',
                ]);

                $pacienteData = $validatedData['paciente'];  
                $paciente = Paciente::create($pacienteData); 
                if ($request->has('responsables')) {
                    $validatedResponsables = $request->validate([
                        'responsables' => 'array', 
                        'responsables.*.nombre_completo' => 'required|string|max:100',
                        'responsables.*.parentesco' => 'required|string|max:100',
                    ]);
                    
                    foreach ($validatedResponsables['responsables'] as $responsableData) {
                        FamiliarResponsable::create([
                            'paciente_id' => $paciente->id,
                            'nombre_completo' => $responsableData['nombre_completo'],
                            'parentesco' => $responsableData['parentesco'],
                        ]);
                    }
                }
                
                return redirect()->route('pacientes.index')
                                ->with('success', 'Paciente registrado correctamente.');

            } catch (\Illuminate\Validation\ValidationException $e) {
                throw $e; 
            } catch (\Exception $e) {
                \Log::error($e->getMessage()); 
                return back()->with('error', 'Error interno: Intenta de nuevo.');
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
        ]);

        $paciente->update($validatedPaciente);

        if ($request->has('responsable')) {
            $validatedResponsable = $request->validate([
                'responsable.nombre_completo' => 'required|string|max:100',
                'responsable.parentesco' => 'required|string|max:100',
            ]);

            $responsableData = [
                'nombre_completo' => $validatedResponsable['responsable']['nombre_completo'],
                'parentesco' => $validatedResponsable['responsable']['parentesco'],
                'paciente_id' => $paciente->id,
            ];

            $familiarResponsable = FamiliarResponsable::where('paciente_id', $paciente->id)->first();

            if ($familiarResponsable) {
                $familiarResponsable->update($responsableData);
            } else {
                FamiliarResponsable::create($responsableData);
            }
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
