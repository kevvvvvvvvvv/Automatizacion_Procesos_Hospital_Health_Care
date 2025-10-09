<?php

namespace Database\Seeders;

use App\Models\FamiliarResponsable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamiliarResponsableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FamiliarResponsable::create([
            'nombre_completo' => 'JAIME ORTÍZ',
            'parentesco' => 'PADRE',
            'paciente_id' => 1,
        ]);


        FamiliarResponsable::create([
            'nombre_completo' => 'MARÍA HERNÁNDEZ',
            'parentesco' => 'MADRE',
            'paciente_id' => 1,
        ]);        

        FamiliarResponsable::create([
            'nombre_completo' => 'PEDRO SOLÍS',
            'parentesco' => 'PADRE',
            'paciente_id' => 2,
        ]);

    }
}
