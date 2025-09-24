<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    User::create([
        'curpc' => 'JUAP850101HDFLRS01',
        'nombre' => 'Juan',
        'apellidop' => 'Pérez',
        'apellidom' => 'Ramírez',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1985-01-01',
        'id_colaborador_responsable' => 'JUAP850101HDFLRS01', // él mismo
        'email' => 'juan.perez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    User::create([
        'curpc' => 'MALO900214MDFLPS02',
        'nombre' => 'María',
        'apellidop' => 'López',
        'apellidom' => 'Santos',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1990-02-14',
        'id_colaborador_responsable' => 'JUAP850101HDFLRS01', // responsable: Juan Pérez
        'email' => 'maria.lopez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    User::create([
        'curpc' => 'CARA820710HDFRMR03',
        'nombre' => 'Carlos',
        'apellidop' => 'Ramírez',
        'apellidom' => 'Moreno',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1982-07-10',
        'id_colaborador_responsable' => 'JUAP850101HDFLRS01', // responsable: Juan Pérez
        'email' => 'carlos.ramirez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    User::create([
        'curpc' => 'LAHE880320MDFHND04',
        'nombre' => 'Laura',
        'apellidop' => 'Hernández',
        'apellidom' => 'Díaz',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1988-03-20',
        'id_colaborador_responsable' => 'CARA820710HDFRMR03', // responsable: Carlos Ramírez
        'email' => 'laura.hernandez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    User::create([
        'curpc' => 'ANGG910923HDFGLZ05',
        'nombre' => 'Andrés',
        'apellidop' => 'González',
        'apellidom' => 'Luna',
        'sexo' => 'Masculino',
        'fechaNacimiento' => '1991-09-23',
        'id_colaborador_responsable' => 'MALO900214MDFLPS02', // responsable: María López
        'email' => 'andres.gonzalez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    User::create([
        'curpc' => 'SOMA950105MDFMRT06',
        'nombre' => 'Sofía',
        'apellidop' => 'Martínez',
        'apellidom' => 'Rojas',
        'sexo' => 'Femenino',
        'fechaNacimiento' => '1995-01-05',
        'id_colaborador_responsable' => 'ANGG910923HDFGLZ05', // responsable: Andrés González
        'email' => 'sofia.martinez@hospital.com',
        'password' => Hash::make('password123'),
    ]);

    }
}
