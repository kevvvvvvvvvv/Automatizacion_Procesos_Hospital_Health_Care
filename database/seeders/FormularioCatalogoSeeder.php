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

        FormularioCatalogo::create([
            'nombre_formulario' => 'Interconsulta',
            'nombre_tabla_fisica' => 'interconsultas',
            'route_prefix' => 'interconsultas',
        ]);

        FormularioCatalogo::create([
            'nombre_formulario' => 'Hoja de enfermería',
            'nombre_tabla_fisica' => 'hoja_enfermerias',
            'route_prefix' => 'hojasenfermerias',
        ]);

        FormularioCatalogo::create([
            'nombre_formulario' => 'Traslados',
            'nombre_tabla_fisica' => 'traslados',
            'route_prefix' => 'traslados',
        ]);
        FormularioCatalogo::create([
            'nombre_formulario' => 'Preoperatoria',
            'nombre_tabla_fisica' => 'preoperatorias',
            'route_prefix' => 'preoperatorias',
        ]);

        FormularioCatalogo::create([
            'nombre_formulario' => 'Nota post-operatoria',
            'nombre_tabla_fisica' => 'nota_postoperatorias',
            'route_prefix' => 'notaspostoperatorias',
        ]);
        
        FormularioCatalogo::create([
            'nombre_formulario' => 'Nota de urgencias',
            'nombre_tabla_fisica' => 'nota_urgencias',
            'route_prefix' => 'notasurgencias',
        ]);
    }
}
