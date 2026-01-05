<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\CredencialEmpleado;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cargo;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class DoctorController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar colaboradores', only: ['index', 'show']),
            new Middleware($permission . ':crear colaboradores', only: ['create', 'store']),
            new Middleware($permission . ':editar colaboradores', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar colaboradores', only: ['destroy']),
        ];
    }

    public function index()
    {
        $query = User::query()
            ->select([
                'id', 'nombre', 'apellido_paterno', 'apellido_materno', 'email', 
                'fecha_nacimiento', 'colaborador_responsable_id', 
                'sexo', 'created_at'
            ])
            ->orderBy('created_at', 'desc');

        $doctores = $query->with(['colaborador_responsable', 'roles'])
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nombre_completo' => $user->nombre_completo,  
                    'email' => $user->email ?? 'No proporcionado',
                    'fecha_nacimiento' => $user->fecha_nacimiento_formateada ?? 'No especificada',  
                    'cargo' => $user->roles->first()?->name ?? 'Sin cargo',
                    'responsable' => $user->colaborador_responsable?->nombre_completo ?? 'Sin responsable', 
                    'created_at' => date('Y-m-d H:i', strtotime($user->created_at)),
                    'sexo' => $user->sexo ?? 'No especificado',
                    'professional_qualifications' => $user->professional_qualifications ?? [], 
                ];
            });
        return Inertia::render('Medicos/index', [
            'doctores' => $doctores,
        ]);
    }

    public function show($id)
    {
        $doctor = User::with(['cargo', 'colaborador_responsable'])->findOrFail($id);
       
        $doctorData = [
            'id' => $doctor->id,
            'nombre' => $doctor->nombre ?? '', 
            'apellido_paterno' => $doctor->apellido_paterno ?? '',
            'apellido_materno' => $doctor->apellido_materno ?? null,
            'nombre_completo' => $doctor->nombre_completo ?? trim(($doctor->nombre ?? '') . ' ' . ($doctor->apellido_paterno ?? '') . ' ' . ($doctor->apellido_materno ?? '')),  
            'fecha_nacimiento' => $doctor->fecha_nacimiento_formateada ?? ($doctor->fecha_nacimiento ? date('d/m/Y', strtotime($doctor->fecha_nacimiento)) : 'No especificada'),  
            'sexo' => $doctor->sexo ?? null,
            'curp' => $doctor->curp ?? null,
            'cargo' => $doctor->cargo?->nombre ?? 'Sin cargo',
            'colaborador_responsable' => $doctor->colaborador_responsable ? [
                'id' => $doctor->colaborador_responsable->id,
                'nombre_completo' => $doctor->colaborador_responsable->nombre_completo ?? 'Sin nombre',  
            ] : null,
            'email' => $doctor->email ?? 'No proporcionado',
            'created_at' => $doctor->created_at ? date('d/m/Y H:i', strtotime($doctor->created_at)) : 'No disponible',  
            'professional_qualifications' => $doctor->professional_qualifications ?? [],  
        ];

        
        return Inertia::render('Medicos/show', [
            'doctor' => $doctorData,
            'credencial' =>$doctor->credenciales,
        ]);
    }

   

    public function store(UserRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::create([
                'nombre'             => $validatedData['nombre'],
                'apellido_paterno'   => $validatedData['apellido_paterno'],
                'apellido_materno'   => $validatedData['apellido_materno'],
                'curp'               => $validatedData['curp'],
                'sexo'               => $validatedData['sexo'],
                'fecha_nacimiento'   => $validatedData['fecha_nacimiento'],
                'telefono'           => $validatedData['telefono'],
                'colaborador_responsable_id' => $validatedData['colaborador_responsable_id'],
                'email'              => $validatedData['email'],
                'password'           => Hash::make($validatedData['password']),
            ]);

            $role = Role::find($validatedData['cargo_id']);
            $user->assignRole($role);

            if (isset($validatedData['professional_qualifications'])) {
                foreach ($validatedData['professional_qualifications'] as $qual) {
                    CredencialEmpleado::create([
                        'user_id'            => $user->id,
                        'titulo'             => $qual['titulo'],
                        'cedula_profesional' => $qual['cedula'] ?? null,
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Fallo al crear doctor: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error al registrar al colaborador');
        }
    }


    public function create()
    {

        $allRolesInDatabase = Role::select('id','name')->get();

        return Inertia::render('Medicos/create', [  
            'cargos' => $allRolesInDatabase, 
            'usuarios' => User::whereNotNull('nombre') 
                ->select(['id', 'nombre', 'apellido_paterno', 'apellido_materno'])  
                ->orderBy('nombre')  
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'nombre_completo' => $user->nombre_completo, 
                    ];
                })->toArray(), 
        ]);
    }


    public function edit(User $doctore)
    {
        $doctore->load(['roles', 'credenciales', 'colaborador_responsable']);
        $user = $doctore;

        $doctorData = [
            'id' => $user->id,
            'nombre' => $user->nombre,
            'apellido_paterno' => $user->apellido_paterno,
            'apellido_materno' => $user->apellido_materno,
            'curp' => $user->curp,
            'sexo' => $user->sexo,
            'fecha_nacimiento' => $user->fecha_nacimiento ? \Carbon\Carbon::parse($user->fecha_nacimiento)->format('Y-m-d') : '',
            'email' => $user->email,
            'telefono' => $user->telefono,
            'colaborador_responsable_id' => $user->colaborador_responsable_id,
            'cargo_id' => $user->roles->first()?->id ?? '', 
            'credenciales' => $user->credenciales->map(function($qual) {
                return [
                    'titulo' => $qual->titulo,
                    'cedula' => $qual->cedula_profesional, 
                ];
            }),
        ];

        $cargos = Role::select('id', 'name')->orderBy('name')->get();
        $usuarios = User::select('id', 'nombre', 'apellido_paterno', 'apellido_materno')
            ->orderBy('nombre')
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'nombre_completo' => $u->nombre_completo,
                ];
            });

        return Inertia::render('Medicos/create', [
            'user' => $doctorData,
            'cargos' => $cargos,
        ]);
    }

    public function update(Request $request, $id)
    {
        $doctor = User::findOrFail($id);  

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'nullable|string|max:100',  
            'curp' => 'nullable|string|max:18|unique:users,curp,' . $id, 
            'sexo' => 'nullable|in:Masculino,Femenino',
            'fecha_nacimiento' => 'required|date',
            'cargo_id' => 'required|exists:cargos,id',
            'colaborador_responsable_id' => 'nullable|exists:users,id',
            'email' => 'required|email|unique:users,email,' . $id,  
            'password' => 'nullable|string|min:8|confirmed',  
            'professional_qualifications' => 'required|array|min:1',  
            'professional_qualifications.*.titulo' => 'required|string|max:100',
            'professional_qualifications.*.cedula' => 'nullable|string|max:20',
        ]);

        $updateData = $validated;
        if (empty($validated['password'])) {
            unset($updateData['password']);  
            unset($updateData['password_confirmation']);
        } else {
            $updateData['password'] = Hash::make($validated['password']);  
            unset($updateData['password_confirmation']);  
        }


        $doctor->update($updateData);

        Log::info('Doctor actualizado:', ['id' => $id, 'data' => $updateData]);

        return redirect()->route('doctores.index')
            ->with('success', 'Doctor actualizado exitosamente.');
    }


    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();

        Log::info('Doctor eliminado:', ['id' => $id]);

        return redirect()->route('doctores.index')
            ->with('success', 'Doctor eliminado exitosamente.');
    }
}
