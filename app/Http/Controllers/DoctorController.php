<?php

namespace App\Http\Controllers;

use App\Models\User;  // Cambia si usas modelo Doctor
use Illuminate\Http\Request;
use App\Models\Cargo; 
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        // Query: Trae TODOS los usuarios/doctores (quita filtros restrictivos temporalmente para debug)
        $query = User::query()
            ->select([
                'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'email', 
                'fecha_nacimiento', 'cargo_id', 'colaborador_responsable_id', 
                'sexo', 'created_at'  // Incluye todos los campos relevantes
            ])
            ->orderBy('created_at', 'desc');  // Nuevos primero

        // Opcional: Si solo quieres "doctores" con cargo, descomenta (pero verifica que cargo_id no sea null)
        // ->whereNotNull('cargo_id')

        // DEBUG TEMPORAL: Verifica cuántos hay en DB
        $totalUsers = $query->count();
        // dd('Total usuarios en DB: ' . $totalUsers);  // Descomenta para ver en pantalla – quita después

        $doctores = $query->with(['cargo', 'colaborador_responsable'])  // Carga relaciones para evitar nulls
            ->get()  // Array completo
            ->map(function ($user) {
                // Mapea a estructura exacta de Doctor (todos los campos)
                return [
                    'id' => $user->id,
                    'nombre_completo' => trim($user->nombre . ' ' . $user->apellido_paterno . ' ' . ($user->apellido_materno ?? '')),
                    'email' => $user->email ?? 'No proporcionado',
                    'fecha_nacimiento' => $user->fecha_nacimiento ? date('Y-m-d', strtotime($user->fecha_nacimiento)) : 'No especificada',
                    'cargo' => $user->cargo ? $user->cargo->nombre : 'Sin cargo',  // Asume relación cargo
                    'responsable' => $user->colaborador_responsable ? trim($user->colaborador_responsable->nombre . ' ' . $user->colaborador_responsable->apellido_paterno) : 'Sin responsable',
                    'created_at' => date('Y-m-d H:i', strtotime($user->created_at)),
                    // Opcionales: Agrega más info si quieres (e.g., sexo, curp)
                    'sexo' => $user->sexo ?? 'No especificado',
                ];
            });

        // DEBUG TEMPORAL: Verifica el array mapeado
        // dd('Doctores mapeados:', $doctores->toArray());  // Descomenta para ver – quita después

        return Inertia::render('Medicos/index', [  // Ajusta a tu ruta de archivo (e.g., 'DoctorIndex' si no usas subcarpeta)
            'doctores' => $doctores,  // Array con TODA la info
            'flash' => $request->session()->get('success'),  // Para mensajes
        ]);
    }
    
    // Asegúrate de tener show() para clic en fila (usa el de antes)
    public function show($id)
    {
        $doctor = User::with(['cargo', 'colaborador_responsable'])->findOrFail($id);
        return Inertia::render('Medicos/show', [  // Ajusta ruta
            'doctor' => [
                'id' => $doctor->id,
                'nombre_completo' => $doctor->nombre . ' ' . $doctor->apellido_paterno . ' ' . ($doctor->apellido_materno ?? ''),
                'email' => $doctor->email,
                'fecha_nacimiento' => $doctor->fecha_nacimiento,
                'cargo' => $doctor->cargo->nombre ?? 'Sin cargo',
                'responsable' => $doctor->colaborador_responsable ? $doctor->colaborador_responsable->nombre_completo : 'Sin responsable',  // Usa accessor si tienes
                // Agrega más: 'sexo' => $doctor->sexo, etc.
            ],
        ]);
    }
    public function create()
{
    $cargos = [];
    $usuarios = [];

    try {
        // Trae cargos (si modelo existe)
        if (class_exists(\App\Models\Cargo::class)) {
            $cargos = Cargo::all(['id', 'nombre'])->toArray();  // Array simple
        } else {
            // Fallback: Array vacío si no hay modelo (crea cargos manuales si quieres)
            $cargos = [
                ['id' => 1, 'nombre' => 'Médico General'],
                ['id' => 2, 'nombre' => 'Especialista en Cardiología'],
                // Agrega más si no tienes DB
            ];
        }

        // Trae usuarios para responsables (evita orderBy en accessor)
        $usuariosQuery = User::whereNotNull('cargo_id')  // Solo con cargo
            ->select(['id', 'nombre', 'apellido_paterno', 'apellido_materno'])  // Campos crudos para map
            ->orderBy('nombre')  // Ordena por nombre (columna real)
            ->get();

        $usuarios = $usuariosQuery->map(function ($user) {
            return [
                'id' => $user->id,
                'nombre_completo' => $user->nombre_completo,  // Usa accessor DESPUÉS de get()
            ];
        })->toArray();

    } catch (\Exception $e) {
        // Si error (e.g., tabla no existe), usa arrays vacíos
        \Log::error('Error en DoctorController::create(): ' . $e->getMessage());  // Log para debug
        $cargos = [];
        $usuarios = [];
    }

    // DEBUG TEMPORAL: Ver en pantalla qué se envía (quita después)
    // dd(['cargos' => $cargos, 'usuarios' => $usuarios]);

    return Inertia::render('Medicos/create', [
        'cargos' => $cargos,  // Siempre array
        'usuarios' => $usuarios,  // Siempre array
    ]);
}

   public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'curp' => 'nullable|string|max:18|unique:users,curp',
            'sexo' => 'nullable|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required|exists:cargos,id', // Ahora valida cargo_id
            'colaborador_responsable_id' => 'nullable|exists:users,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'curp' => $validated['curp'] ?? null,
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'],
            'sexo' => $validated['sexo'] ?? null,
            'fecha_nacimiento' => $validated['fecha_nacimiento'],
            'cargo_id' => $validated['cargo_id'], // Guardar ID del cargo
            'colaborador_responsable_id' => $validated['colaborador_responsable_id'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('Medicos/index')
            ->with('success', 'Doctor registrado exitosamente.');
    }
}
