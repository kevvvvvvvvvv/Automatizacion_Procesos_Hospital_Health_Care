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
        $roleAdmin = Role::firstOrCreate(['name' => 'administrador']);
        $roleMedico = Role::firstOrCreate(['name' => 'medico']);
        $roleMedicoEspecialista = Role::firstOrCreate(['name' => 'medico especialista']);
        $roleEnfermera = Role::firstOrCreate(['name' => 'enfermera(o)']);
        $roleAdministrativos = Role::firstOrCreate(['name' => 'administrativo']);
        $roleCocina = Role::firstOrCreate(['name' => 'cocina']);
        $roleFarmacia = Role::firstOrCreate(['name' => 'farmacia']);
        $roleRadiologo = Role::firstOrCreate(['name' => 'radiólogo']);
        $roleTecnicoLaboratorio = Role::firstOrCreate(['name' => 'técnico de laboratorio']);
        $roleFisoterapeuta = Role::firstOrCreate(['name' => 'fisoterapeuta']);
        $roleRecepcion = Role::firstOrCreate(['name' => 'recepcion']);
        $roleCaja = Role::firstOrCreate(['name'  => 'caja']);
        $roleQuimico = Role::firstOrCreate(['name' => 'químico']);
        $roleMantenimiento = Role::firstOrCreate(['name' => 'mantenimiento']);
        $roleLimpieza = Role::firstOrCreate(['name' => 'limpieza']);
        $roleSistemas = Role::firstOrCreate(['name' => 'sistemas']);

        $permissions = [
            'sistemas' => ['crear', 'consultar', 'editar', 'eliminar'],
            'mantenimiento' => [ 'consultar', 'editar'],
            'limpieza' => ['consultar', 'editar'],
            
            'reportes' => ['consultar'],

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
            'solicitudes estudios' => ['crear','editar','consultar','eliminar'],
            'solicitudes estudios patologicos' => ['crear','editar','consultar','eliminar'],

            'documentos medicos' => ['crear', 'consultar'],
            'consentimientos' => ['crear'],
            'dietas' => ['consultar', 'crear', 'eliminar', 'editar'],

            'base de datos' => ['consultar', 'respaldar','restaurar'],
            'peticion medicamentos' => ['consultar','editar', 'crear'],
            'peticion dietas' => ['consultar','editar'],
        ];

        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$action} {$module}",
                ]);
            }
        }

        $roleAdmin->syncPermissions(Permission::all());
        $roleSistemas->syncPermissions(Permission::all());

       $roleLimpieza->syncPermissions([
            'editar limpieza',    // Cambiado de 'editar reportes'
            'consultar limpieza'  // Cambiado de 'consultar reportes'
        ]); 

        $roleMantenimiento->syncPermissions([
            'editar mantenimiento',    // Cambiado de 'editar reportes'
            'consultar mantenimiento'  // Cambiado de 'consultar reportes'
        ]);

        $roleRecepcion->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',

            'crear estancias',
            'consultar estancias',
            
            'crear consentimientos',

            'crear hojas frontales',
            'consultar hojas frontales',
        ]);
        
        $roleEnfermera->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',

            'consultar estancias',
            'crear estancias',

            'consultar hojas enfermerias',
            'crear hojas enfermerias',

            'consultar hojas', 
            
            'consultar solicitudes estudios',
            'crear solicitudes estudios',

            'consultar solicitudes estudios patologicos',
            'crear solicitudes estudios patologicos'
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

        $roleMedicoEspecialista->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',

            'crear estancias',
            'editar estancias',
            'consultar estancias',

            'consultar hojas',
            'crear hojas',
            'eliminar hojas', 

            'consultar hojas enfermerias',
            
            'consultar documentos medicos',
            'crear documentos medicos',

            'consultar solicitudes estudios',
            'crear solicitudes estudios',

            'consultar solicitudes estudios patologicos',
            'crear solicitudes estudios patologicos',

            'crear hojas frontales',
            'consultar hojas frontales',

            'crear consentimientos',
            
            'consultar habitaciones',
        ]);
        
        $roleMedico->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',

            'crear estancias',
            'editar estancias',
            'consultar estancias',

            'consultar hojas',
            'crear hojas',
            'eliminar hojas', 

            'consultar hojas enfermerias',
            
            'consultar documentos medicos',
            'crear documentos medicos',

            'consultar solicitudes estudios',
            'crear solicitudes estudios',

            'consultar solicitudes estudios patologicos',
            'crear solicitudes estudios patologicos',

            'crear consentimientos',
            
            'consultar habitaciones',

            'crear hojas frontales',
            'consultar hojas frontales',
        ]);

        $roleFarmacia->syncPermissions([
            'consultar peticion medicamentos',
            'editar peticion medicamentos',
        ]);

        $roleCocina->syncPermissions([
            'consultar dietas',
            'editar dietas',
            'crear dietas',
            'eliminar dietas',

            'consultar peticion dietas',
            'editar peticion dietas',
        ]);

        $roleRadiologo->syncPermissions([
            'consultar pacientes',
            'crear pacientes',
            'editar pacientes',

            'consultar solicitudes estudios',
            'crear solicitudes estudios',
            'editar solicitudes estudios',
            'eliminar solicitudes estudios'
        ]);
    }
}
