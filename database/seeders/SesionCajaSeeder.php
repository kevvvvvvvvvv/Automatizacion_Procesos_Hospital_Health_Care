<?php

namespace Database\Seeders;

use App\Models\Caja\Caja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Caja\SesionCaja;

class SesionCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $bovedaId = Caja::where('tipo', 'boveda')->first()?->id;
        $fondoId = Caja::where('tipo', 'fondo')->first()?->id;

        SesionCaja::firstOrCreate(
        [
            'estado' => 'abierta',
            'caja_id' => $bovedaId,
        ],
        [
            'user_id' => 33,
            'fecha_apertura' => now(),
            'monto_inicial' => 50000,
        ]);

        SesionCaja::firstOrCreate(
        [
            'estado' => 'abierta',
            'caja_id' => $fondoId,
        ],
        [
            'user_id' => 33,
            'fecha_apertura' => now(),
            'monto_inicial' => 10000,
        ]);
    }
}
