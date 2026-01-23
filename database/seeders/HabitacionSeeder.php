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
            'identificador' => 'Consultorio 1',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta Ayutla',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 2',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 3',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 4',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 5',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 1',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Gustavo Díaz Ordaz',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 2',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Gustavo Díaz Ordaz',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Consultorio 3',
            'tipo' => 'Consultorio',
            'estado' => 'Libre',
            'ubicacion' => 'Gustavo Díaz Ordaz',
            'piso' => 'Planta baja',
        ]);


        //Habiracions para hospitalización
        Habitacion::create([
            'identificador' => 'Suit 1A',
            'tipo' => 'Habitación',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
        ]);

        Habitacion::create([
            'identificador' => 'Suit 1B',
            'tipo' => 'Habitación',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta baja',
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

         Habitacion::create([
            'identificador' => 'Quirofano',
            'tipo' => 'Quirofano',
            'estado' => 'Libre',
            'ubicacion' => 'Plan de Ayutla',
            'piso' => 'Planta Alta',
        ]);
    }
}
