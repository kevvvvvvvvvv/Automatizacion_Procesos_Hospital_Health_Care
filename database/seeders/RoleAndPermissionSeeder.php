<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleMedico = Role::create(['name' => 'medico']);
        $roleMedicoEspecialista = Role::create(['name' => 'medico_especialista']);
        $roleEnfermera = Role::create(['name' => 'enfermera']);
        $roleAdministrativos = Role::create(['name' => 'administrativos']);
        $roleCocina = Role::create(['name' => 'cocina']);
        $roleMantenimiento = Role::create(['name' => 'mantenimiento']);
        $roleFarmacia = Role::create(['name' => 'farmacia']);
        $roleTecnicoRadiologo = Role::create(['name' => 'tecnico_radiologo']);
        $roleTecnicoLaboratorio = Role::create(['name' => 'tecnico_laboratorio']);
        $roleFisoterapeuta = Role::create(['name' => 'fisoterapeuta']);
        $roleRecepcion = Role::create(['name' => 'recepcion']);

        $permissions = [
            'pacientes' => ['crear', 'consultar', 'editar', 'eliminar'],
            'estancias' => ['crear', 'consultar', 'editar', 'eliminar'],
            'hojas frontales' => ['crear', 'consultar', 'editar', 'eliminar'],
            'habitaciones' => ['crear', 'consultar', 'editar', 'eliminar'],
            'colaboradores' => ['crear', 'consultar', 'editar', 'eliminar'],
            'productos y servivicios' => ['crear', 'consultar', 'editar', 'eliminar'],
            'historial' =>['consultar'],
            'hojas' => ['crear', 'consultar', 'editar', 'eliminar',], 
            'hojas enfermerias' => ['crear', 'consultar', 'eliminar'], // Solo se puede editar el documento que una persona creó
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$module}",
                ]);
            }
        }

        $roleAdmin->syncPermissions(Permission::all());

        $roleRecepcion->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',
        ]);
        
        $roleEnfermera->syncPermissions([
            'consultar hojas enfermerias',
            'crear hojas enfermerias',
        ]);
    }
}
