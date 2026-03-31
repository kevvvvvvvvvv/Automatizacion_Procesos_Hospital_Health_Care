<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

use App\Models\Cargo;
use App\Models\CredencialEmpleado;
use App\Models\User;

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
                'nombre'           => $validatedData['nombre'],
                'apellido_paterno' => $validatedData['apellido_paterno'],
                'apellido_materno' => $validatedData['apellido_materno'],
                'curp'             => $validatedData['curp'],
                'sexo'             => $validatedData['sexo'],
                'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
                'telefono'         => $validatedData['telefono'],
                'colaborador_responsable_id' => $validatedData['colaborador_responsable_id'],
                'email'            => $validatedData['email'],
                'password'         => Hash::make($validatedData['password']),
            ]);

            $role = Role::find($validatedData['cargo_id']);
            $user->assignRole($role);

            if (!empty($validatedData['professional_qualifications'])) {
                foreach ($validatedData['professional_qualifications'] as $qual) {
                    $cedulaValor = $qual['cedula_profesional'] ?? ($qual['cedula'] ?? null);
                    if (!empty($qual['titulo'])) {
                        CredencialEmpleado::create([
                            'user_id'            => $user->id,
                            'titulo'             => $qual['titulo'],
                            'cedula_profesional' => $cedulaValor ?? '', 
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Doctor creado correctamente.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error detallado en store: " . $e->getMessage());
            return back()->withInput()->with('error', 'Error al registrar: ' . $e->getMessage());
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
        $credenciales = $user->credenciales;
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
            'credenciales' => $credenciales,
        ]);
    }

   public function update(UserRequest $request, $id)
    {
        $doctor = User::findOrFail($id);  

        $validated = $request->validated();

        DB::beginTransaction();
        try {
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
                unset($validated['password_confirmation']); 
            }

            $doctor->update($validated);

            if (isset($validated['cargo_id'])) {
                $role = Role::find($validated['cargo_id']);
                $doctor->syncRoles([$role->name]);
            }

            if (isset($validated['professional_qualifications'])) {
                $doctor->credenciales()->delete(); 
                
                foreach ($validated['professional_qualifications'] as $qual) {
                    if (!empty($qual['titulo'])) {
                        $doctor->credenciales()->create([
                            'titulo' => $qual['titulo'],
                            'cedula_profesional' => $qual['cedula_profesional'] ?? ($qual['cedula'] ?? null),
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->back()
                ->with('success', 'Doctor actualizado exitosamente.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar doctor: " . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al actualizar los datos.');
        }
    }


    public function destroy($id)
    {
        $doctor = User::findOrFail($id);
        $doctor->delete();
        
        return redirect()->route('doctores.index')
            ->with('success', 'Doctor eliminado exitosamente.');
    }
}
