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

        //Permisos
        $permissions = [
            'pacientes' => ['crear', 'consultar', 'editar', 'eliminar'],
            'estancia' => ['crear', 'consultar', 'editar', 'eliminar'],
            'hojafrontal' => ['crear', 'consultar', 'editar', 'eliminar'],
            'habitacion' => ['crear', 'consultar', 'editar', 'eliminar'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$module}",
                ]);
            }
        }
        

        
        
    }
}
