<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estancia;

class EstanciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estancia::create([
            'folio' => '12892025',
            'paciente_id' => 1,
            'fecha_ingreso' => '2025-09-28 10:00',
            'tipo_estancia' => 'Interconsulta',
            'modalidad_ingreso' => 'Particular',
            'familiar_responsable_id' => 1,
            'created_by' => 7
        ]);

        Estancia::create([
            'folio' => '11282025',
            'paciente_id' => 1,
            'fecha_ingreso' => '2025-08-12 14:30',
            'fecha_egreso' => '2025-08-20 09:00',
            'habitacion_id' => 2,
            'estancia_anterior_id' => 1,
            'tipo_estancia' => 'Hospitalizacion',
            'modalidad_ingreso' => 'Particular',
            'familiar_responsable_id' => 2,
            'created_by' => 7
        ]);
    }
}
