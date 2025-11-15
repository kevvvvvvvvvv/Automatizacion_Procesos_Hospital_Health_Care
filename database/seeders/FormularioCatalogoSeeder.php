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
            'id' => 1,
            'nombre_formulario' => 'Hoja frontal',
            'nombre_tabla_fisica' => 'hoja_frontales',
            'route_prefix' => 'hojasfrontales',
        ]);

        FormularioCatalogo::create([
            'id' => 2,
            'nombre_formulario' => 'Historia clínica',
            'nombre_tabla_fisica' => 'historia_clinicas',
            'route_prefix' => 'historiasclinicas',
        ]);

        FormularioCatalogo::create([
            'id' => 3,
            'nombre_formulario' => 'Interconsulta',
            'nombre_tabla_fisica' => 'interconsultas',
            'route_prefix' => 'interconsultas',
        ]);

        FormularioCatalogo::create([
            'id'=> 4,
            'nombre_formulario' => 'Hoja de enfermería',
            'nombre_tabla_fisica' => 'hoja_enfermerias',
            'route_prefix' => 'hojasenfermerias',
        ]);

        FormularioCatalogo::create([
            'id' => 5,
            'nombre_formulario' => 'Traslados',
            'nombre_tabla_fisica' => 'traslados',
            'route_prefix' => 'traslados',
        ]);
        FormularioCatalogo::create([
            'id' => 6,
            'nombre_formulario' => 'Preoperatoria',
            'nombre_tabla_fisica' => 'preoperatorias',
            'route_prefix' => 'preoperatorias',
        ]);
        
        FormularioCatalogo::create([
            'id' => 7,
            'nombre_formulario' => 'Nota postoperatoria',
            'nombre_tabla_fisica' => 'nota_postoperatorias',
            'route_prefix' => 'notaspostoperatorias',
        ]);


        FormularioCatalogo::create([
            'id' => 8,
            'nombre_formulario' => 'Nota de urgencias',
            'nombre_tabla_fisica' => 'nota_urgencias',
            'route_prefix' => 'notasurgencias',
        ]);

        FormularioCatalogo::create([
            'id' => 9,
            'nombre_formulario' => 'Estudio anatomopatológico',
            'nombre_tabla_fisica' => 'solicitud_patologias',
            'route_prefix' => 'solicitudes-patologias'
        ]);

        FormularioCatalogo::create([
            'id' => 10,
            'nombre_formulario' => 'Nota de egreso',
            'nombre_tabla_fisica' => 'nota_egreso',
            'route_prefix' => 'notasegresos',
        ]);

        
    }
}
