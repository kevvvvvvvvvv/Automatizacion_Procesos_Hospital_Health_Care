<?php

namespace Database\Seeders;

use App\Models\Caja\Caja;
use App\Models\Caja\SesionCaja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Caja::create([
            'activa' => true,
            'id' => 1,
            'nombre' => 'Caja principal',
            'tipo' => 'operativo'
        ]);

        Caja::create([
            'activa' => true,
            'id' => 2,
            'nombre' => 'Fondo',
            'tipo' => 'fondo'
        ]);

        Caja::create([
            'activa' => true,
            'id' => 3,
            'nombre' => 'Boveda',
            'tipo' => 'boveda'
        ]);

        Caja::create([
            'activa' => true,
            'id' => 4,
            'nombre' => 'Fondo de líderes de tiendas',
            'tipo' => 'fondo'
        ]);
    }
}
