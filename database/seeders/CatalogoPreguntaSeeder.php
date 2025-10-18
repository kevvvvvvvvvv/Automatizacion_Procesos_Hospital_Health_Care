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
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Diabetes',
            'orden' => 2,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cardiovasculares',
            'orden' => 3,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Neoplásicos (cáncer)', 'orden' => 4, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Tipo de cáncer', 'type' => 'text'],
                ['name' => 'fecha', 'label' => 'Fecha de diagnóstico', 'type' => 'month_unknown']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hipertensión',
            'orden' => 5,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Psiquiátricos',
            'orden' => 6,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Epilepsia',
            'orden' => 7,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos',
            'orden' => 8,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Tipo', 'type' => 'text'],
                ['name' => 'tiempo', 'label' => '¿Desde hace cuánto tiempo?', 'type' => 'month_unknown'],
            ]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 9,
            'categoria' => 'heredo_familiares',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        //No patólogicos
        CatalogoPregunta::create([
            'pregunta' => 'Alcoholismo', 'orden' => 10, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Tipo de sustancia', 'type' => 'text'],
                ['name' => 'frecuencia', 'label' => 'Frecuencia (litros por semana)', 'type' => 'text']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tabaquismo', 'orden' => 11, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'frecuencia', 'label' => 'Frecuencia (cajetillas por semana)', 'type' => 'text']
            ])
        ]);


        CatalogoPregunta::create([
            'pregunta' => 'Toxicomanías',
            'orden' => 12,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Tipo de sustancia', 'type' => 'text'],
                ['name' => 'frecuencia', 'label' => 'Frecuencia (unidades por semana)', 'type' => 'text']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Grupo Sanguíneo', 'orden' => 13, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 
            'opciones_respuesta' => json_encode([
                ['value' => 'Conozco',   'label' => 'Conozco',   'triggersFields' => true],
                ['value' => 'Desconozco','label' => 'Desconozco', 'triggersFields' => false]
            ]),
            'campos_adicionales' => json_encode([
                ['name' => 'grupo', 'label' => 'Grupo', 'type' => 'select', 'options' => ['A', 'B', 'AB', 'O']]
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'RH', 'orden' => 14, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'opciones_respuesta' => json_encode([
                ['value' => 'Conozco',   'label' => 'Conozco',   'triggersFields' => true],
                ['value' => 'Desconozco','label' => 'Desconozco', 'triggersFields' => false]
            ]),        
            'campos_adicionales' => json_encode([
                ['name' => 'rh', 'label' => 'Factor RH', 'type' => 'select', 'options' => ['+', '-']]
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Alergías',
            'orden' => 15,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Deporte practicado',
            'orden' => 16,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2,
           'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Deporte', 'type' => 'text'],
                ['name' => 'frecuencia', 'label' => 'Frecuencia (horas por semana)', 'type' => 'text']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Consumo de medicamentos',
            'orden' => 17,
            'categoria' => 'no_patologicos',
            'formulario_catalogo_id' => 2,
           'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([])
        ]);

        //A patologicos
        CatalogoPregunta::create([
            'pregunta' => 'Quirúrgicos', 'orden' => 18, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible',
            'campos_adicionales' => json_encode([
                ['name' => 'cirugia', 'label' => 'Tipo de cirugía', 'type' => 'text'],
                ['name' => 'tiempo', 'label' => 'Hace cuánto tiempo', 'type' => 'month_unknown']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Infecciones',
            'orden' => 19,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'],
                ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Diabetes', 'orden' => 20, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'],
                ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hipertensión', 'orden' => 21, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'],
                ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Transfusionales', 'orden' => 22, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tiempo', 'label' => 'Hace cuánto tiempo', 'type' => 'text'],
                ['name' => 'aplicacion', 'label' => '¿Qué se aplicó?', 'type' => 'select', 'options' => ['Plaquetas', 'Plasma', 'Paquete globular (Sangre)']]
            ])
        ]);    

        CatalogoPregunta::create([
            'pregunta' => 'VIH', 'orden' => 23, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'adquisicion', 'label' => 'Tipo de adquisición', 'type' => 'select', 'options' => ['Adquirido', 'Congénito (heredado)']],
                ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo (si fue adquirido)', 'type' => 'text', 'dependsOn' => 'adquisicion', 'dependsValue' => 'Adquirido'],
                ['name' => 'control', 'label' => '¿Se controla?', 'type' => 'select', 'options' => ['Si', 'No']],
                ['name' => 'mediacamento', 'label' => 'Medicamento(s)', 'type' => 'text', 'dependsOn' => 'control', 'dependsValue' => 'Si'],
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Neoplásicos (cáncer)', 'orden' => 24, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Tipo de cáncer', 'type' => 'text'],
                ['name' => 'fecha', 'label' => 'Fecha de diagnóstico', 'type' => 'month_unknown']
            ])
        ]);
    
        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos',
            'orden' => 25,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'tipo', 'label' => 'Especificar', 'type' => 'text'],
                ['name' => 'fecha', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']
            ])            
        ]);  

        CatalogoPregunta::create([
            'pregunta' => 'Otro',
            'orden' => 26,
            'categoria' => 'a_patologicos',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),           
        ]);  

        //Gineco-obstetrico
        CatalogoPregunta::create([
            'pregunta' => 'Gesta',
            'orden' => 27,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'cantidad', 'label' => 'Número', 'type' => 'number']
            ])
        ]);  

        CatalogoPregunta::create([
            'pregunta' => 'Partos',
            'orden' => 28,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'cantidad', 'label' => 'Número', 'type' => 'number']
            ])
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Abortos', 'orden' => 29, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible',
            'campos_adicionales' => json_encode([
                ['name' => 'causa', 'label' => 'Causa del aborto', 'type' => 'select', 'options' => ['Espontáneo', 'Inducido', 'Séptico', 'Inminente', 'Amenaza de aborto', 'Incompleto', 'Diferido','Desconozco']],
            ])
        ]);


        CatalogoPregunta::create([
            'pregunta' => 'Cesareas',
            'orden' => 30,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'cantidad', 'label' => 'Número', 'type' => 'number'],
                ['name' => 'razon', 'label' => 'Razón de cesáreas', 'type' => 'text'],
            ])
        ]);
        
        CatalogoPregunta::create([
            'pregunta' => 'Menarca',
            'orden' => 31,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'cantidad', 'label' => 'Número', 'type' => 'number']
            ])
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Ritmo', 'orden' => 32, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 
            'campos_adicionales' => json_encode([
                ['name' => 'ritmo', 'label' => 'Ritmo', 'type' => 'select', 'options' => ['Regular', 'Irregular', 'Amenorrea']]
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Inicio de Vida Sexual Activa',
            'orden' => 33,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 
            'campos_adicionales' => json_encode([
                ['name' => 'fecha', 'label' => 'Edad de inicio', 'type' => 'number'],
            ])
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Última Menstruación',
            'orden' => 34,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 
            'campos_adicionales' => json_encode([
                ['name' => 'fecha', 'label' => 'Fecha (o marcar si se desconoce)', 'type' => 'month_unknown'],
            ])
        ]); 

        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Último Papanicolaou', 'orden' => 35, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 
            'campos_adicionales' => json_encode([
                ['name' => 'fecha', 'label' => 'Fecha (o marcar si se desconoce)', 'type' => 'month_unknown'],
                ['name' => 'alteraciones', 'label' => 'Alteraciones', 'type' => 'text']
            ])
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Control de Natalidad',
            'orden' => 36,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos',
            'campos_adicionales' => json_encode([
                ['name' => 'consultas', 'label' => '¿A cuántas consultas asistió?', 'type' => 'number'],
                ['name' => 'trimestre', 'label' => '¿A partir de qué trimestre?', 'type' => 'number']
            ])   
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 37,
            'categoria' => 'gineco_obstetrico',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        //Exploracion fisica
        CatalogoPregunta::create([
            'pregunta' => 'Cráneo',
            'orden' => 38,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cara',
            'orden' => 39,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reflejos pupilares',
            'orden' => 40,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Fondo de ojo',
            'orden' => 41,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Nariz',
            'orden' => 42,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
           'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Boca',
            'orden' => 43,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Amígdalas',
            'orden' => 44,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Oídos',
            'orden' => 45,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cuello',
            'orden' => 46,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Adenomegalias',
            'orden' => 47,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Pulsos carotídeos',
            'orden' => 48,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tiroides',
            'orden' => 49,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tórax',
            'orden' => 50,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Glándulas mamarias',
            'orden' => 51,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Abdomen',
            'orden' => 52,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hernias',
            'orden' => 53,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Visceromegalías',
            'orden' => 54,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Genitales',
            'orden' => 55,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Columna',
            'orden' => 56,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Pelvis',
            'orden' => 57,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Extremidades superiores',
            'orden' => 58,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Hombro',
            'orden' => 59,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Codo',
            'orden' => 60,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Muñeca y mano',
            'orden' => 61,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Muñeca y mano',
            'orden' => 62,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Extremidades inferiores',
            'orden' => 63,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Cadera',
            'orden' => 64,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Rodilla',
            'orden' => 65,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Tobillo y pie',
            'orden' => 66,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Reflejos osteotendinosos',
            'orden' => 67,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Piel y faneros',
            'orden' => 68,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);

        CatalogoPregunta::create([
            'pregunta' => 'Otros',
            'orden' => 69,
            'categoria' => 'exploracion_fisica',
            'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple',
            'campos_adicionales' => json_encode([]),
        ]);
    }
}
