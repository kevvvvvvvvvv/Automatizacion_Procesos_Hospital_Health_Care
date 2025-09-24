<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paciente::create([
            'nombre' => 'José Martínez',
            'edad' => 45,
            'email' => 'jose.martinez@correo.com',
            'telefono' => '555-1111',
        ]);

        Paciente::create([
            'nombre' => 'Ana Torres',
            'edad' => 32,
            'email' => 'ana.torres@correo.com',
            'telefono' => '555-2222',
        ]);

        Paciente::create([
            'nombre' => 'Miguel Sánchez',
            'edad' => 60,
            'email' => 'miguel.sanchez@correo.com',
            'telefono' => '555-3333',
        ]);

        Paciente::create([
            'nombre' => 'Lucía Fernández',
            'edad' => 27,
            'email' => 'lucia.fernandez@correo.com',
            'telefono' => '555-4444',
        ]);

        Paciente::create([
            'nombre' => 'Pedro Gómez',
            'edad' => 50,
            'email' => 'pedro.gomez@correo.com',
            'telefono' => '555-5555',
        ]);

        Paciente::create([
            'nombre' => 'Elena Ruiz',
            'edad' => 38,
            'email' => 'elena.ruiz@correo.com',
            'telefono' => '555-6666',
        ]);

    }
}
