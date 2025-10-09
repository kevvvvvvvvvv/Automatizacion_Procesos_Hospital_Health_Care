<?php

namespace Database\Seeders;

use App\Models\Cargo; 
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    public function run(): void
    {
        $cargos = [
            ['nombre' => 'Médico General', 'descripcion' => 'Atención primaria.'],
            ['nombre' => 'Cirujano', 'descripcion' => 'Especialista en cirugías.'],
            ['nombre' => 'Pediatra', 'descripcion' => 'Atención a niños.'],
            ['nombre' => 'Enfermero', 'descripcion' => 'Asistente médico.'],
        ];

        foreach ($cargos as $cargo) {
            Cargo::create($cargo);
        }
    }
}
