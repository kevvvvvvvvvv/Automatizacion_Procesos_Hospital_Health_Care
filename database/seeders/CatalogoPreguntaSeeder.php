<?php

namespace Database\Seeders;

use App\Models\CatalogoPregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatalogoPreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Heredo familiares
        CatalogoPregunta::create([
            'pregunta' => 'Obesidad',
            'orden' => 1,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Diabetes',
            'orden' => 2,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cardiovasculares',
            'orden' => 3,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Neoplásticos',
            'orden' => 4,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hipertensión',
            'orden' => 5,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Psiquiátricos',
            'orden' => 6,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Epilepsia',
            'orden' => 7,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos',
            'orden' => 8,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 9,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2
        ]);

        //No patólogicos
        CatalogoPregunta::create([
            'pregunta' => 'Alcoholismo',
            'orden' => 10,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tabaquísmo',
            'orden' => 11,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Toxicomanías',
            'orden' => 12,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Grupo RH',
            'orden' => 13,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Alergías',
            'orden' => 14,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Deporte practicado',
            'orden' => 15,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Barreras arquitec',
            'orden' => 16,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Transporte',
            'orden' => 17,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        //A patologicos
        CatalogoPregunta::create([
            'pregunta' => 'Quirúrgicos',
            'orden' => 18,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Infecciones',
            'orden' => 19,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cronicos degenerativos',
            'orden' => 20,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Transfuncionales',
            'orden' => 21,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);        

        CatalogoPregunta::create([
            'pregunta' => 'VIH',
            'orden' => 22,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);  

        CatalogoPregunta::create([
            'pregunta' => 'Neoplásicos',
            'orden' => 23,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);  
    
        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos',
            'orden' => 24,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);  

        CatalogoPregunta::create([
            'pregunta' => 'Otro',
            'orden' => 25,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2
        ]);  

        //Gineco-obstetrico
        CatalogoPregunta::create([
            'pregunta' => 'Gesta',
            'orden' => 26,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]);  

        CatalogoPregunta::create([
            'pregunta' => 'Partos',
            'orden' => 27,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Abortos',
            'orden' => 28,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Cesarías',
            'orden' => 29,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]);
        
        CatalogoPregunta::create([
            'pregunta' => 'Menarca',
            'orden' => 30,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Ritmo',
            'orden' => 31,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Inicio de Vida Sexual Activa',
            'orden' => 32,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Última Menstruación',
            'orden' => 33,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Última Papanicolaou',
            'orden' => 34,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Control de Natalidad',
            'orden' => 35,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 36,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2
        ]);

        //Exploracion fisica
        CatalogoPregunta::create([
            'pregunta' => 'Cráneo',
            'orden' => 37,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cara',
            'orden' => 38,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reflejos pupilares',
            'orden' => 39,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Fondo de ojo',
            'orden' => 40,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Nariz',
            'orden' => 41,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Boca',
            'orden' => 42,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Amígdalas',
            'orden' => 43,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Oídos',
            'orden' => 44,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cuello',
            'orden' => 45,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Adenomegalias',
            'orden' => 46,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Pulsos carotídeos',
            'orden' => 47,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tiroides',
            'orden' => 48,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tórax',
            'orden' => 49,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Glándulas mamarias',
            'orden' => 50,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Abdomen',
            'orden' => 51,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hernias',
            'orden' => 52,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Visceromegalías',
            'orden' => 53,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Genitales',
            'orden' => 54,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Columna',
            'orden' => 55,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Pelvis',
            'orden' => 56,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Extremidades superiores',
            'orden' => 57,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hombro',
            'orden' => 58,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Codo',
            'orden' => 59,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Muñeca y mano',
            'orden' => 60,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Muñeca y mano',
            'orden' => 61,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Extremidades inferiores',
            'orden' => 62,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cadera',
            'orden' => 63,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Rodilla',
            'orden' => 64,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tobillo y pie',
            'orden' => 65,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reflejos osteotendinosos',
            'orden' => 66,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Piel y faneros',
            'orden' => 67,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 68,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2
        ]);
    }
}
