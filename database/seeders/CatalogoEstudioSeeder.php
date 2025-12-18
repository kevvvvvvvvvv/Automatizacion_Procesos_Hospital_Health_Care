<?php

namespace Database\Seeders;

use App\Models\CatalogoEstudio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class CatalogoEstudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::transaction(function () {
            DB::table('catalogo_estudios')->delete();
            $path = database_path('seeders/data/catalogo_laboratorios.csv');

            $stream = fopen($path, 'r');
            
            $csv = Reader::createFromStream($stream);
            $csv->setDelimiter(','); 
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();
            $dataToInsert = [];
            $chunkSize = 500;

            foreach ($records as $record) {
                $codigoRaw = trim($record['codigo'] ?? '');
                $tiempoRaw = trim($record['tiempo_entrega'] ?? '');
                $costoRaw  = str_replace(['$', ',', ' '], '', $record['costo'] ?? '');

                $dataToInsert[] = [
                    'codigo'         => is_numeric($codigoRaw) ? (int)$codigoRaw : null,
                    'nombre'         => trim($record['nombre'] ?? ''),
                    'tipo_estudio'   => trim($record['tipo_estudio'] ?? ''),
                    'departamento'   => trim($record['departamento'] ?? ''),
                    
                    'tiempo_entrega' => is_numeric($tiempoRaw) ? (int)$tiempoRaw : null,
                    'costo'          => (is_numeric($costoRaw)) ? (float)$costoRaw : 0.00,

                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];

                if (count($dataToInsert) >= $chunkSize) {
                    DB::table('catalogo_estudios')->insert($dataToInsert);
                    $dataToInsert = [];
                }
            }

            if (!empty($dataToInsert)) {
                DB::table('catalogo_estudios')->insert($dataToInsert);
            }

            if (is_resource($stream)) {
                fclose($stream);
            }            
        });

        /*
        CatalogoEstudio::insert([
            [
                'codigo' => 1,
                'nombre' => 'Glucosa',
                'tipo_estudio' => 'Laboratorio',
                'departamento' => 'Química Clínica',
                'tiempo_entrega' => 1, 
                'costo' => 50.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 2,
                'nombre' => 'Urea',
                'tipo_estudio' => 'Laboratorio',
                'departamento' => 'Química Clínica',
                'tiempo_entrega' => 1,
                'costo' => 60.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 3,
                'nombre' => 'Creatinina',
                'tipo_estudio' => 'Laboratorio',
                'departamento' => 'Química Clínica',
                'tiempo_entrega' => 1,
                'costo' => 65.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'codigo' => 4,
                'nombre' => 'Depuración de Creatinina 24 hrs',
                'tipo_estudio' => 'Laboratorio',
                'departamento' => 'Uroanálisis',
                'tiempo_entrega' => 2,
                'costo' => 150.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'codigo' => 101, 
                'nombre' => 'Pélvico suprapúbico',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Ultrasonido',
                'tiempo_entrega' => 1,
                'costo' => 450.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 102,
                'nombre' => 'Pélvico endovaginal',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Ultrasonido',
                'tiempo_entrega' => 1,
                'costo' => 550.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 201,
                'nombre' => 'Tele de Tórax',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Radiología',
                'tiempo_entrega' => 1,
                'costo' => 300.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 202,
                'nombre' => 'Cráneo AP y Lateral',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Radiología',
                'tiempo_entrega' => 1,
                'costo' => 350.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'codigo' => 301,
                'nombre' => 'Tomografía Simple',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Tomografía Computada',
                'tiempo_entrega' => 2,
                'costo' => 2000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 302,
                'nombre' => 'Tomografía Contrastada',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Tomografía Computada',
                'tiempo_entrega' => 2,
                'costo' => 3000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'codigo' => 401,
                'nombre' => 'Resonancia Simple',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Resonancia',
                'tiempo_entrega' => 3,
                'costo' => 4000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 402,
                'nombre' => 'Resonancia de Cráneo',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Resonancia',
                'tiempo_entrega' => 3,
                'costo' => 5000.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'codigo' => 403,
                'nombre' => 'Resonancia de Columna Cervical',
                'tipo_estudio' => 'Imagenología',
                'departamento' => 'Resonancia',
                'tiempo_entrega' => 3,
                'costo' => 5500.00,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ]);
        */
    }
}
