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
        $roleAdmin = Role::create(['name' => 'administrador']);
        $roleMedico = Role::create(['name' => 'medico']);
        $roleMedicoEspecialista = Role::create(['name' => 'medico especialista']);
        $roleEnfermera = Role::create(['name' => 'enfermera(o)']);
        $roleAdministrativos = Role::create(['name' => 'administrativos']);
        $roleCocina = Role::create(['name' => 'cocina']);
        $roleMantenimiento = Role::create(['name' => 'mantenimiento']);
        $roleFarmacia = Role::create(['name' => 'farmacia']);
        $roleTecnicoRadiologo = Role::create(['name' => 'técnico radiólogo']);
        $roleTecnicoLaboratorio = Role::create(['name' => 'técnico de laboratorio']);
        $roleFisoterapeuta = Role::create(['name' => 'fisoterapeuta']);
        $roleRecepcion = Role::create(['name' => 'recepcion']);
        $roleCaja = Role::create(['name'  => 'caja']);

        $permissions = [
            'pacientes' => ['crear', 'consultar', 'editar', 'eliminar'],
            'estancias' => ['crear', 'consultar', 'editar', 'eliminar'],
            'hojas frontales' => ['crear', 'consultar', 'editar', 'eliminar'],
            'habitaciones' => ['crear', 'consultar', 'editar', 'eliminar'],
            'colaboradores' => ['crear', 'consultar', 'editar', 'eliminar'],
            'productos y servicios' => ['crear', 'consultar', 'editar', 'eliminar'],
            'historial' =>['consultar'],
            'ventas' => ['consultar','eliminar','editar','crear'],
            'detalles ventas' => ['consultar','eliminar','editar','crear'],
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
            'crear estancias'
        ]);
        
        $roleEnfermera->syncPermissions([
            'consultar hojas enfermerias',
            'crear hojas enfermerias',
        ]);

        $roleCaja->syncPermissions([
            'consultar pacientes',
            'consultar estancias',

            
            'consultar ventas',
            'crear ventas',
            'editar ventas',
            'eliminar ventas',
            
            'consultar detalles ventas',
            'crear detalles ventas',
            'editar detalles ventas',
            'eliminar detalles ventas',

            'consultar productos y servicios',
            'crear productos y servicios',
            'editar productos y servicios',
            'eliminar productos y servicios',
        ]);
    }
}
