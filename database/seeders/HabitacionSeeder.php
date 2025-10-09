<?php

namespace Database\Seeders;

use App\Models\Habitacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habitacion::create([
            'identificador' => 'Suit 1A',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 1B',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 2',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 3',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 4',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 5',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 6',
            'estado' => 'Libre',
            'piso' => 'Planta Baja',
        ]);
    }
}
