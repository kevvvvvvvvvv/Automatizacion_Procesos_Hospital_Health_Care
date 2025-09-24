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
            Doctor::create([
            'nombre' => 'Dr. Juan Pérez',
            'especialidad' => 'Cardiología',
            'email' => 'juan.perez@hospital.com',
            'telefono' => '555-1234',
        ]);

        Doctor::create([
            'nombre' => 'Dra. María López',
            'especialidad' => 'Pediatría',
            'email' => 'maria.lopez@hospital.com',
            'telefono' => '555-5678',
        ]);

        Doctor::create([
            'nombre' => 'Dr. Carlos Ramírez',
            'especialidad' => 'Neurología',
            'email' => 'carlos.ramirez@hospital.com',
            'telefono' => '555-8765',
        ]);

        Doctor::create([
            'nombre' => 'Dra. Laura Hernández',
            'especialidad' => 'Ginecología',
            'email' => 'laura.hernandez@hospital.com',
            'telefono' => '555-4321',
        ]);

        Doctor::create([
            'nombre' => 'Dr. Andrés González',
            'especialidad' => 'Dermatología',
            'email' => 'andres.gonzalez@hospital.com',
            'telefono' => '555-2468',
        ]);

        Doctor::create([
            'nombre' => 'Dra. Sofía Martínez',
            'especialidad' => 'Oftalmología',
            'email' => 'sofia.martinez@hospital.com',
            'telefono' => '555-1357',
        ]);

    }
}
