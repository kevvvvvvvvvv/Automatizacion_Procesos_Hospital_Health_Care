<?php

namespace Database\Seeders;

use App\Models\CatalogoPregunta;
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
            'pregunta' => 'Obesidad', 'orden' => 1, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Diabetes', 'orden' => 2, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Cardiovasculares', 'orden' => 3, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Neoplásicos (cáncer)', 'orden' => 4, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Tipo de cáncer', 'type' => 'text'], ['name' => 'fecha', 'label' => 'Fecha de diagnóstico', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Hipertensión', 'orden' => 5, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Psiquiátricos', 'orden' => 6, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Epilepsia', 'orden' => 7, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos', 'orden' => 8, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Tipo', 'type' => 'text'], ['name' => 'tiempo', 'label' => '¿Desde hace cuánto tiempo?', 'type' => 'month_unknown']],
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Otros', 'orden' => 9, 'categoria' => 'heredo_familiares', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);

        //No patológicos
        CatalogoPregunta::create([
            'pregunta' => 'Alcoholismo', 'orden' => 10, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Tipo de sustancia', 'type' => 'text'], ['name' => 'frecuencia', 'label' => 'Frecuencia (litros por semana)', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Tabaquismo', 'orden' => 11, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'frecuencia', 'label' => 'Frecuencia (cajetillas por semana)', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Toxicomanías', 'orden' => 12, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Tipo de sustancia', 'type' => 'text'], ['name' => 'frecuencia', 'label' => 'Frecuencia (unidades por semana)', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Grupo Sanguíneo', 'orden' => 13, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false,
            'opciones_respuesta' => [['value' => 'Conozco', 'label' => 'Conozco', 'triggersFields' => true], ['value' => 'Desconozco', 'label' => 'Desconozco', 'triggersFields' => false]],
            'campos_adicionales' => [['name' => 'grupo', 'label' => 'Grupo', 'type' => 'select', 'options' => ['A', 'B', 'AB', 'O']]]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'RH', 'orden' => 14, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false,
            'opciones_respuesta' => [['value' => 'Conozco', 'label' => 'Conozco', 'triggersFields' => true], ['value' => 'Desconozco', 'label' => 'Desconozco', 'triggersFields' => false]],
            'campos_adicionales' => [['name' => 'rh', 'label' => 'Factor RH', 'type' => 'select', 'options' => ['+', '-']]]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Alergías', 'orden' => 15, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Deporte practicado', 'orden' => 16, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Deporte', 'type' => 'text'], ['name' => 'frecuencia', 'label' => 'Frecuencia (horas por semana)', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Consumo de medicamentos', 'orden' => 17, 'categoria' => 'no_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);

        //A patológicos
        CatalogoPregunta::create([
            'pregunta' => 'Quirúrgicos', 'orden' => 18, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cirugia', 'label' => 'Tipo de cirugía', 'type' => 'text'], ['name' => 'tiempo', 'label' => 'Hace cuánto tiempo', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Infecciones', 'orden' => 19, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'], ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Diabetes', 'orden' => 20, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'], ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Hipertensión', 'orden' => 21, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'control', 'label' => '¿Con qué se controla?', 'type' => 'text'], ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Transfusionales', 'orden' => 22, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tiempo', 'label' => 'Hace cuánto tiempo', 'type' => 'text'], ['name' => 'aplicacion', 'label' => '¿Qué se aplicó?', 'type' => 'select', 'options' => ['Plaquetas', 'Plasma', 'Paquete globular (Sangre)']]]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'VIH', 'orden' => 23, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'adquisicion', 'label' => 'Tipo de adquisición', 'type' => 'select', 'options' => ['Adquirido', 'Congénito (heredado)']], ['name' => 'tiempo', 'label' => 'Desde hace cuánto tiempo (si fue adquirido)', 'type' => 'text', 'dependsOn' => 'adquisicion', 'dependsValue' => 'Adquirido'], ['name' => 'control', 'label' => '¿Se controla?', 'type' => 'select', 'options' => ['Si', 'No']], ['name' => 'medicamento', 'label' => 'Medicamento(s)', 'type' => 'text', 'dependsOn' => 'control', 'dependsValue' => 'Si']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Neoplásicos (cáncer)', 'orden' => 24, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Tipo de cáncer', 'type' => 'text'], ['name' => 'fecha', 'label' => 'Fecha de diagnóstico', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Reumáticos', 'orden' => 25, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'tipo', 'label' => 'Especificar', 'type' => 'text'], ['name' => 'fecha', 'label' => 'Desde hace cuánto tiempo', 'type' => 'month_unknown']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Otro', 'orden' => 26, 'categoria' => 'a_patologicos', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);

        //Gineco-obstétrico
        CatalogoPregunta::create([
            'pregunta' => 'Gesta', 'orden' => 27, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cantidad', 'label' => 'Número', 'type' => 'number']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Partos', 'orden' => 28, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cantidad', 'label' => 'Número', 'type' => 'number']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Abortos', 'orden' => 29, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cantidad', 'label' => 'Número de abortos', 'type' => 'number'],['name' => 'causa', 'label' => 'Causa del aborto', 'type' => 'text']]
        ]);
        /*CatalogoPregunta::create([
            'pregunta' => 'Abortos', 'orden' => 29, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'repetible', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'causa', 'label' => 'Causa del aborto', 'type' => 'select', 'options' => ['Espontáneo', 'Inducido', 'Séptico', 'Inminente', 'Amenaza de aborto', 'Incompleto', 'Diferido', 'Desconozco']]]
        ]);*/
        CatalogoPregunta::create([
            'pregunta' => 'Cesáreas', 'orden' => 30, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cantidad', 'label' => 'Número', 'type' => 'number'], ['name' => 'razon', 'label' => 'Razón de cesáreas', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Menarca', 'orden' => 31, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'cantidad', 'label' => 'Edad', 'type' => 'number']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Ritmo', 'orden' => 32, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'ritmo', 'label' => 'Ritmo', 'type' => 'select', 'options' => ['Regular', 'Irregular', 'Amenorrea']]]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Inicio de Vida Sexual Activa', 'orden' => 33, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'fecha', 'label' => 'Edad de inicio', 'type' => 'number']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Última Menstruación', 'orden' => 34, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'fecha', 'label' => 'Fecha', 'type' => 'date']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Fecha de Último Papanicolaou', 'orden' => 35, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'fecha', 'label' => 'Fecha', 'type' => 'month_unknown'], ['name' => 'alteraciones', 'label' => 'Alteraciones', 'type' => 'text']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Control de Natalidad', 'orden' => 36, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'multiple_campos', 'permite_desconozco' => false, 'opciones_respuesta' => null,
            'campos_adicionales' => [['name' => 'consultas', 'label' => '¿A cuántas consultas asistió?', 'type' => 'number'], ['name' => 'trimestre', 'label' => '¿A partir de qué trimestre?', 'type' => 'number']]
        ]);
        CatalogoPregunta::create([
            'pregunta' => 'Otros', 'orden' => 37, 'categoria' => 'gineco_obstetrico', 'formulario_catalogo_id' => 2,
            'tipo_pregunta' => 'simple', 'campos_adicionales' => [], 'permite_desconozco' => false, 'opciones_respuesta' => null,
        ]);

        $exploracionFisica = [
            'Cráneo', 'Cara', 'Reflejos pupilares', 'Fondo de ojo', 'Nariz', 'Boca',
            'Amígdalas', 'Oídos', 'Cuello', 'Adenomegalias', 'Pulsos carotídeos', 'Tiroides',
            'Tórax', 'Glándulas mamarias', 'Abdomen', 'Hernias', 'Visceromegalías', 'Genitales',
            'Columna', 'Pelvis', 'Extremidades superiores', 'Hombro', 'Codo', 'Muñeca y mano',
            'Extremidades inferiores', 'Cadera', 'Rodilla', 'Tobillo y pie',
            'Reflejos osteotendinosos', 'Piel y faneros', 'Otros'
        ];
        $orden = 38;
        foreach ($exploracionFisica as $pregunta) {
            CatalogoPregunta::create([
                'pregunta' => $pregunta,
                'orden' => $orden++,
                'categoria' => 'exploracion_fisica',
                'formulario_catalogo_id' => 2,
                'tipo_pregunta' => 'simple',
                'campos_adicionales' => [],
                'permite_desconozco' => false,
                'opciones_respuesta' => null,
            ]);
        }
    }
}

