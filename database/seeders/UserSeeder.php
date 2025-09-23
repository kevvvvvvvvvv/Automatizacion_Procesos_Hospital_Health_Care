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
    }
}
