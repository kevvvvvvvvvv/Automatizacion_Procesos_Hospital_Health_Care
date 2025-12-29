<?php

namespace Database\Seeders;

use App\Models\HabitacionPrecio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HabitacionPrecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $habitaciones = [1, 2, 3, 4, 5, 6, 7, 8];

        foreach ($habitaciones as $habitacionId) {
            
            $horaInicio = Carbon::parse('08:00:00');
            $horaFinDia = Carbon::parse('23:00:00');

            while ($horaInicio < $horaFinDia) {
                $finBloque = $horaInicio->copy()->addMinutes(30);

                
                if ($finBloque > $horaFinDia) break;

                HabitacionPrecio::create([
                    'habitacion_id'  => $habitacionId,
                    'horario_inicio' => $horaInicio->format('H:i:s'),
                    'horario_fin'    => $finBloque->format('H:i:s'),
                    'precio'         => 100 
                ]);

                $horaInicio->addMinutes(30);
            }
        }
    }
}
