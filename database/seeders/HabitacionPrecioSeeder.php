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
        $idsDiazOrdaz = [1, 2, 3, 4, 5]; 
        $idsPlanAyutla = [6, 7, 8];


        $todasLasHabitaciones = array_merge($idsDiazOrdaz, $idsPlanAyutla);

        foreach ($todasLasHabitaciones as $habitacionId) {
            
            $horaInicio = Carbon::parse('08:00:00');
            $horaFinDia = Carbon::parse('23:00:00');

            while ($horaInicio < $horaFinDia) {
                $finBloque = $horaInicio->copy()->addMinutes(30);
                
                if ($finBloque > $horaFinDia) break;

                $horaActual = $horaInicio->format('H:i');
                $precio = 0;

                if (in_array($habitacionId, $idsDiazOrdaz)) {
                    // (9-12) y (16-19) -> 75
                    if (
                        ($horaActual >= '09:00' && $horaActual < '12:00') || 
                        ($horaActual >= '16:00' && $horaActual < '19:00')
                    ) {
                        $precio = 75;
                    }
                    // (7-9) y (12:30 - 14:30 pm) -> 40
                    elseif (
                        ($horaActual >= '07:00' && $horaActual < '09:00') || 
                        ($horaActual >= '12:30' && $horaActual < '14:30')
                    ) {
                        $precio = 40;
                    }
                    // Los demás -> 50
                    else {
                        $precio = 50;
                    }

                } elseif (in_array($habitacionId, $idsPlanAyutla)) {
                    // (9-12) y (16-19) -> 90
                    if (
                        ($horaActual >= '09:00' && $horaActual < '12:00') || 
                        ($horaActual >= '16:00' && $horaActual < '19:00')
                    ) {
                        $precio = 90;
                    }
                    // (7-9) y (12:30 - 14:30 ) -> 55
                    elseif (
                        ($horaActual >= '07:00' && $horaActual < '09:00') || 
                        ($horaActual >= '12:30' && $horaActual < '14:30')
                    ) {
                        $precio = 55;
                    }
                    // Los demás -> 65
                    else {
                        $precio = 65;
                    }
                }

                HabitacionPrecio::create([
                    'habitacion_id'  => $habitacionId,
                    'horario_inicio' => $horaInicio->format('H:i:s'),
                    'horario_fin'    => $finBloque->format('H:i:s'),
                    'precio'         => $precio
                ]);
                
                $horaInicio->addMinutes(30);
            }
        }
    }
}
