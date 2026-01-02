<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoriaDietaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categorias = [
            'Dieta de liquidos claros',
            'Dieta blanda - Desayuno',
            'Dieta blanda - Comida',
            'Dieta blanda - Cena',
            'Dieta para paciente diabético',
            'Dieta para paciente celiaco',
            'Dieta para paciente oncológico',
        ];

        foreach ($categorias as $categoria) {
            DB::table('categoria_dietas')->updateOrInsert(
                ['categoria' => $categoria], 
                ['created_at' => $now, 'updated_at' => $now]
            );
        }
    }
}
