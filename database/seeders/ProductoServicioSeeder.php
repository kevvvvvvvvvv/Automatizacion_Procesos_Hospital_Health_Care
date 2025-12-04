<?php

namespace Database\Seeders;

use App\Models\ProductoServicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ProductoServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            DB::table('producto_servicios')->delete();

            $path = database_path('seeders/data/producto_servicios.csv');
        
            $stream = fopen($path, 'r');
            

            stream_filter_append($stream, 'convert.iconv.ISO-8859-1/UTF-8');
            

            $csv = Reader::createFromStream($stream);

            $csv->setDelimiter(';'); 
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();
            $dataToInsert = [];
            $chunkSize = 500;

            foreach ($records as $record) {
                if (empty($record['codigo_prestacion']) && empty($record['nombre_prestacion'])) {
                    continue;
                }

                $dataToInsert[] = [
                    'tipo'              => trim($record['tipo'] ?? ''),
                    'subtipo'           => trim($record['subtipo'] ?? ''),
                    'codigo_prestacion' => trim($record['codigo_prestacion'] ?? ''),
                    'nombre_prestacion' => trim($record['nombre_prestacion'] ?? ''),
                    'importe'           => isset($record['importe']) ? floatval(str_replace(',', '', $record['importe'])) : 0,
                    'cantidad'          => empty($record['cantidad']) ? null : (int)$record['cantidad'],
                    'iva' => empty($record['iva']) 
                                ? null 
                                : (float)str_replace('%', '', $record['iva']),
                ];

                if (count($dataToInsert) >= $chunkSize) {
                    DB::table('producto_servicios')->insert($dataToInsert);
                    $dataToInsert = [];
                }
            }

            if (!empty($dataToInsert)) {
                DB::table('producto_servicios')->insert($dataToInsert);
            }

            if (is_resource($stream)) {
                fclose($stream);
            }
        });

        ProductoServicio::create([
            'tipo' => 'SERVICIOS',
            'subtipo' => 'ADMISION',
            'codigo_prestacion' => '',
            'nombre_prestacion' => 'LLENADO DE HOJA FRONTAL',
            'importe' => 0.1,
            'cantidad' => null,
        ]);

        ProductoServicio::create([
            'tipo' => 'SERVICIOS',
            'subtipo' => 'ESTUDIOS',
            'codigo_prestacion' => '85121801_01',
            'nombre_prestacion' => 'SOLICITUD PATOLOGÍA',
            'importe' => 0.1,
            'cantidad' => null,
        ]);
    }
}