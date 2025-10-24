<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FormularioCatalogo;

class FormularioCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormularioCatalogo::create([
            'nombre_formulario' => 'Hoja frontal',
            'nombre_tabla_fisica' => 'hoja_frontales',
            'route_prefix' => 'hojasfrontales',
        ]);

        FormularioCatalogo::create([
            'nombre_formulario' => 'Historia clínica',
            'nombre_tabla_fisica' => 'historia_clinicas',
            'route_prefix' => 'historiasclinicas',
        ]);

        FormularioCatalogo::create([
            'nombre_formulario' => 'Interconsulta',
            'nombre_tabla_fisica' => 'interconsultas',
            'route_prefix' => 'interconsultas',
        ]);
    }
}
