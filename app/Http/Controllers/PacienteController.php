<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\FamiliarResponsable;  // Cambia a el modelo correcto
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
        try {
            // Valida los campos anidados bajo 'paciente'
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

            // Extrae los datos de 'paciente' y crea el registro
            $pacienteData = $validatedData['paciente'];  // Esto obtiene el array de paciente
            $paciente = Paciente::create($pacienteData);  // Crea el paciente con los datos validados
            
            // Maneja el responsable, que ya está anidado correctamente
            if ($request->has('responsable')) {
                $validatedResponsable = $request->validate([
                    'responsable.nombre_completo' => 'required|string|max:100',
                    'responsable.parentesco' => 'required|string|max:100',
                ]);
                
                FamiliarResponsable::create([
                    'paciente_id' => $paciente->id,
                    'nombre_completo' => $validatedResponsable['responsable']['nombre_completo'],
                    'parentesco' => $validatedResponsable['responsable']['parentesco'],
                ]);
            }
            
            return redirect()->route('pacientes.index')->with('success', 'Paciente registrado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Devuelve los errores al frontend para que Inertia los maneje
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());  // Graba el error en los logs
            return back()->with('error', 'Error interno: Intenta de nuevo. Revisa los logs para más detalles.');
        }
    }
    

    public function show(Paciente $paciente)
    {
        $paciente->load('estancias');
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
    

    public function generarConsentimiento($pacienteId, $medicoId)
    {
        // Obtener el paciente registrado por ID
        $paciente = Paciente::find($pacienteId);
        
        // Obtener el médico registrado por ID
        $medico = Medico::find($medicoId);
        
        // Si no existen, puedes manejar errores (opcional)
        if (!$paciente || !$medico) {
            return redirect()->back()->with('error', 'Paciente o médico no encontrado.');
        }
        
        // Generar el PDF usando el HTML (puedes usar DomPDF o similar)
        $html = view('consentimiento', compact('paciente', 'medico'))->render();
        $pdf = PDF::loadHTML($html)->setPaper('a4');
        
        // Descargar o guardar el PDF
        return $pdf->download('consentimiento_medico.pdf');
    }
}
