<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cargo;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;  // Para logs

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->select([
                'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'email', 
                'fecha_nacimiento', 'cargo_id', 'colaborador_responsable_id', 
                'sexo', 'created_at'
            ])
            ->orderBy('created_at', 'desc');

        $doctores = $query->with(['cargo', 'colaborador_responsable'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nombre_completo' => $user->nombre_completo,  // Usa accessor
                    'email' => $user->email ?? 'No proporcionado',
                    'fecha_nacimiento' => $user->fecha_nacimiento_formateada ?? 'No especificada',  // CORREGIDO: snake_case
                    'cargo' => $user->cargo?->nombre ?? 'Sin cargo',
                    'responsable' => $user->colaborador_responsable?->nombre_completo ?? 'Sin responsable',  // Usa accessor
                    'created_at' => date('Y-m-d H:i', strtotime($user->created_at)),
                    'sexo' => $user->sexo ?? 'No especificado',
                    'professional_qualifications' => $user->professional_qualifications ?? [],  // AGREGADO
                ];
            });

        // DEBUG TEMPORAL: Comenta después
        // Log::info('Doctores en index:', $doctores->toArray());

        return Inertia::render('Medicos/index', [
            'doctores' => $doctores,
            'flash' => $request->session()->get('success'),
        ]);
    }

    public function show($id)
    {
        $doctor = User::with(['cargo', 'colaborador_responsable'])->findOrFail($id);

        // Mapeo COMPLETO para coincidir con type Doctor en frontend
        $doctorData = [
            'id' => $doctor->id,
            'nombre' => $doctor->nombre ?? '',  // Crudo para fallback
            'apellido_paterno' => $doctor->apellido_paterno ?? '',
            'apellido_materno' => $doctor->apellido_materno ?? null,
            'nombre_completo' => $doctor->nombre_completo ?? trim(($doctor->nombre ?? '') . ' ' . ($doctor->apellido_paterno ?? '') . ' ' . ($doctor->apellido_materno ?? '')),  // Accessor o fallback
            'fecha_nacimiento' => $doctor->fecha_nacimiento_formateada ?? ($doctor->fecha_nacimiento ? date('d/m/Y', strtotime($doctor->fecha_nacimiento)) : 'No especificada'),  // CORREGIDO: snake_case
            'sexo' => $doctor->sexo ?? null,
            'curp' => $doctor->curp ?? null,
            'cargo' => $doctor->cargo?->nombre ?? 'Sin cargo',
            'colaborador_responsable' => $doctor->colaborador_responsable ? [
                'id' => $doctor->colaborador_responsable->id,
                'nombre_completo' => $doctor->colaborador_responsable->nombre_completo ?? 'Sin nombre',  // Accessor o fallback
            ] : null,
            'email' => $doctor->email ?? 'No proporcionado',
            'created_at' => $doctor->created_at ? date('d/m/Y H:i', strtotime($doctor->created_at)) : 'No disponible',  // Formateado
            'professional_qualifications' => $doctor->professional_qualifications ?? [],  // AGREGADO: Array de {titulo, cedula}
        ];

        
        return Inertia::render('Medicos/show', [
            'doctor' => $doctorData,
        ]);
    }

   

     public function store(Request $request)
    {
        // Validar campos básicos de users (SIN professional_qualifications)
        $validatedBasic = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',
            'curp' => 'nullable|string|max:18|unique:users,curp', // Unique para evitar duplicados
            'sexo' => 'nullable|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required|exists:cargos,id', // Asumiendo tabla cargos
            'colaborador_responsable_id' => 'nullable|exists:users,id', // Otros usuarios
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Requerido en creación, con confirmed para password_confirmation
        ]);
        // Validar el array de professional_qualifications por separado (al menos uno)
        $qualificationsData = $request->validate([
            'professional_qualifications' => 'required|array|min:1',
            'professional_qualifications.*.titulo' => 'required|string|max:100',
            'professional_qualifications.*.cedula' => 'nullable|string|max:50|unique:credencial_empleados,cedula', // Unique global
        ], [
            'professional_qualifications.*.cedula.unique' => 'La cédula ya está registrada para otro empleado.',
        ]);
        // Crear el usuario en users (solo con campos básicos - NO incluye el array)
        $user = User::create([
            'nombre' => $validatedBasic['nombre'],
            'apellido_paterno' => $validatedBasic['apellido_paterno'],
            'apellido_materno' => $validatedBasic['apellido_materno'],
            'curp' => $validatedBasic['curp'],
            'sexo' => $validatedBasic['sexo'],
            'fecha_nacimiento' => $validatedBasic['fecha_nacimiento'],
            'cargo_id' => $validatedBasic['cargo_id'],
            'colaborador_responsable_id' => $validatedBasic['colaborador_responsable_id'],
            'email' => $validatedBasic['email'],
            'password' => Hash::make($validatedBasic['password']), // Hash con bcrypt
        ]);
        // AHORA procesar el array y crear filas en credencial_empleados
        // Cada ítem del array = una fila con id_user = $user->id (nuevo ID)
        foreach ($qualificationsData['professional_qualifications'] as $qual) {
            CredencialEmpleado::create([
                'id_user' => $user->id, // Foreign key al nuevo usuario
                'titulo' => $qual['titulo'],
                'cedula' => $qual['cedula'] ?? null, // Null si vacío (nullable en BD)
            ]);
        }
        // Redirigir con éxito (Inertia maneja flash messages)
        return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente.');
    }
    // En create: Pasa props para selects (si no lo tienes)
    public function create()
    {
        return Inertia::render('Medicos/create', [  // Nota: Corrige el nombre si es 'Medicos/create'
            'cargos' => \App\Models\Cargo::all(['id', 'nombre']), // Asumiendo modelo Cargo existe
            'usuarios' => User::whereNotNull('nombre')  // Filtra por columna real (nombre no null)
                ->select(['id', 'nombre', 'apellido_paterno', 'apellido_materno'])  // Solo columnas reales
                ->orderBy('nombre')  // Ordena por columna real
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'nombre_completo' => $user->nombre_completo,  // Accessor: Se computa en memoria
                    ];
                })->toArray(),  // Convierte a array para Inertia
        ]);
    }


    public function edit($id)
    {
        $doctor = User::with(['cargo', 'colaborador_responsable'])->findOrFail($id);
        // Mapea datos del doctor (como en show(), pero con IDs para form)
        $doctorData = [
            'id' => $doctor->id,
            'nombre' => $doctor->nombre ?? '',
            'apellido_paterno' => $doctor->apellido_paterno ?? '',
            'apellido_materno' => $doctor->apellido_materno ?? null,
            'curp' => $doctor->curp ?? null,
            'sexo' => $doctor->sexo ?? null,
            'fecha_nacimiento' => $doctor->fecha_nacimiento ? $doctor->fecha_nacimiento->format('Y-m-d') : null,  // Formato para <input type="date">
            'cargo_id' => $doctor->cargo_id ?? null,
            'colaborador_responsable_id' => $doctor->colaborador_responsable_id ?? null,
            'email' => $doctor->email ?? '',
            'professional_qualifications' => $doctor->professional_qualifications ?? [],
        ];
        $cargos = [];
        $usuarios = [];
        try {
            
            if (class_exists(\App\Models\Cargo::class)) {
                $cargos = Cargo::all(['id', 'nombre'])->toArray();
            } else {
                $cargos = [
                    ['id' => 1, 'nombre' => 'Médico General'],
                    ['id' => 2, 'nombre' => 'Especialista en Cardiología'],
                ];
            }
            // CORREGIDO: Igual que en create() – campos reales en query, map después
            $usuariosQuery = User::whereNotNull('cargo_id')
                ->select(['id', 'nombre', 'apellido_paterno', 'apellido_materno'])  // Solo columnas reales
                ->orderBy('nombre')  // Ordena por columna real
                ->get();
            $usuarios = $usuariosQuery->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nombre_completo' => $user->nombre_completo,  // Accessor después de get()
                ];
            })->toArray();
        } catch (\Exception $e) {
            Log::error('Error en DoctorController::edit(): ' . $e->getMessage());
            $cargos = [];
            $usuarios = [];
        }
        // DEBUG TEMPORAL: Verifica en consola (comenta después)
        // Log::info('Datos en edit:', ['doctor' => $doctorData, 'usuarios' => $usuarios]);
        return Inertia::render('Medicos/edit', [
            'doctor' => $doctorData,
            'cargos' => $cargos,
            'usuarios' => $usuarios,
        ]);
    }

    // AGREGADO: Método update() para manejar la actualización del doctor
    public function update(Request $request, $id)
    {
        $doctor = User::findOrFail($id);  // Encuentra el doctor por ID

        // Validación: Similar a store, pero ignora el ID actual en unique constraints
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',  // Opcional
            'curp' => 'nullable|string|max:18|unique:users,curp,' . $id,  // Ignora propio ID
            'sexo' => 'nullable|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required|exists:cargos,id',
            'colaborador_responsable_id' => 'nullable|exists:users,id',
            'email' => 'required|email|unique:users,email,' . $id,  // Ignora propio ID
            'password' => 'nullable|string|min:8|confirmed',  // OPCIONAL: Solo si se proporciona
            'professional_qualifications' => 'required|array|min:1',  // Array de al menos 1
            'professional_qualifications.*.titulo' => 'required|string|max:100',
            'professional_qualifications.*.cedula' => 'nullable|string|max:20',
        ]);

        // Prepara datos para update (password solo si no está vacío)
        $updateData = $validated;
        if (empty($validated['password'])) {
            unset($updateData['password']);  // No actualizar password si no se proporciona
            unset($updateData['password_confirmation']);
        } else {
            $updateData['password'] = Hash::make($validated['password']);  // Hash si se proporciona
            unset($updateData['password_confirmation']);  // No guardar confirm
        }

        // Actualiza el doctor
        $doctor->update($updateData);

        // Opcional: Log para debug
        Log::info('Doctor actualizado:', ['id' => $id, 'data' => $updateData]);

        return redirect()->route('doctores.index')
            ->with('success', 'Doctor actualizado exitosamente.');
    }

    // AGREGADO: Método destroy() para eliminar (opcional, si lo usas en el index)
    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        Log::info('Doctor eliminado:', ['id' => $id]);

        return redirect()->route('doctores.index')
            ->with('success', 'Doctor eliminado exitosamente.');
    }
}
