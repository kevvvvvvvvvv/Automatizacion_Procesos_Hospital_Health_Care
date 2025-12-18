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
            'tipo' => 'Habitación',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 1B',
            'tipo' => 'Habitación',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 2',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 3',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 4',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 5',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 6',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de ayutla',
            'piso' => 'Planta Baja',
        ]);
    }
}
