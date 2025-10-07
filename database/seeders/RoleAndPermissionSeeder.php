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
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'medico']);
        $role = Role::create(['name' => 'medico_especialista']);
        $role = Role::create(['name' => 'enfermera']);
        $role = Role::create(['name' => 'administrativos']);
        $role = Role::create(['name' => 'cocina']);
        $role = Role::create(['name' => 'mantenimiento']);
        $role = Role::create(['name' => 'farmacia']);
        $role = Role::create(['name' => 'tecnico_radiologo']);
        $role = Role::create(['name' => 'tecnico_laboratio']);
        $role = Role::create(['name' => 'fisoterapeuta']);

        $permission = Permission::create(['name' => 'edit articles']);
        
        
        $role->givePermissionTo($permission);
    }
}
