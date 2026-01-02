<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DietaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $opcionesDeDieta = [
            'Dieta de liquidos claros' => [
                '1 pieza de gelatina de sabor: piña, limón, manzana, uva (sujeto a disponibilidad). 1 vaso de té de manzanilla sin añadir azúcar de 250 ml. 1 vaso de jugo de manzana diluido (125 ml de agua y 125 ml de jugo). 1 vaso de agua natural de 250 ml.',
            ],
            'Dieta blanda - Desayuno' => [
                'Omelette de espinacas con queso panela',
                'Waffles de avena con miel y fruta',
                'Huevo a la mexicana sin picante',
                'Huevo revuelto con jamón de pavo',
                'Caldito de verduras con pollo deshebrado',
            ],
            'Dieta blanda - Comida' => [
                'Pechuga asada con verduras al vapor',
                'Caldito de verduras con pollo deshebrado',
                'Fajitas de pollo con zanahoria, cebolla y queso panela en cubos',
                'Rollitos de pechuga rellenas de calabacitas o zanahoria fileteadas en caldillo de jitomate',
                'Consomé sin verduras ni pollo (paciente bichectomía)',
            ],
            'Dieta blanda - Cena' => [
                'Huevo revuelto con jamón de pavo',
                'Waffles de avena con miel y fruta',
                '2 quesadillas de queso panela (con tortillas de maíz)',
                'Sándwich de jamón de pavo (pan integral)',
                'Huevo a la mexicana sin picante',
            ],
            'Dieta para paciente diabético' => [
                'Omelette de espinacas o champiñones con queso panela',
                'Huevo revuelto con jamón de pavo o huevo a la mexicana sin picante',
                'Pechuga asada con guarnición de verduras al vapor',
                'Sándwich de pollo deshebrado con queso panela y verdura (usar pan integral)',
                'Caldito de verduras con pollo deshebrado',
            ],
            'Dieta para paciente celiaco' => [
                '2 quesadillas de queso panela (con tortillas de maíz)',
                'Omelette de espinacas con queso panela',
                'Pechuga asada con guarnición de verduras al vapor',
                'Rollitos de pechuga rellenas de calabacitas o zanahoria fileteadas en caldillo de jitomate',
                'Caldito de verduras con pollo deshebrado',
            ],
            'Dieta para paciente oncológico' => [
                'Frutas hervidas (manzana y pera), opcional retirar la cáscara',
                'Papilla de verduras cocidas con pollo deshebrado',
                'Fajitas de pollo con zanahoria, cebolla y queso panela en cubos',
                'Huevo revuelto con jamón de pavo o huevo a la mexicana sin picante',
                '2 quesadillas de queso panela (con tortillas de maíz)',
            ],
        ];

        foreach ($opcionesDeDieta as $nombreCategoria => $alimentos) {
            $categoriaId = DB::table('categoria_dietas')
                ->where('categoria', $nombreCategoria)
                ->value('id');

            if (!$categoriaId) {
                continue; 
            }

            foreach ($alimentos as $alimentoDesc) {
                DB::table('dietas')->insert([ 
                    'categoria_dieta_id' => $categoriaId,
                    'alimento'           => $alimentoDesc,
                    'costo'              => 100,
                    'created_at'         => $now,
                    'updated_at'         => $now,
                ]);
            }
        }
    }
}
