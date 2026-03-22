<?php

namespace Database\Seeders;

use App\Models\Caja\Caja;
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
        ]);
    }
}
