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
            // Limpiar tablas para evitar duplicados si es necesario
            DB::table('catalogo_estudios')->delete();
            DB::table('producto_servicios')->delete();

            $path = database_path('seeders/data/catalogo_laboratorios.csv');
            $stream = fopen($path, 'r');
            
            $csv = Reader::createFromStream($stream);
            $csv->setDelimiter(','); 
            $csv->setHeaderOffset(0);

            $records = $csv->getRecords();

            foreach ($records as $record) {
                $costoRaw = str_replace(['$', ',', ' '], '', $record['costo'] ?? '');
                $importe = is_numeric($costoRaw) ? (float)$costoRaw : 0.00;

                $productoServicioId = DB::table('producto_servicios')->insertGetId([
                    'codigo_prestacion' => trim($record['clave_producto_servicio']),
                    'tipo'              => 'SERVICIOS',
                    'subtipo'           => 'ESTUDIOS',
                    'nombre_prestacion' => trim($record['nombre'] ?? '') . ' ' . trim($record['departamento'] ?? ''),
                    'importe'           => $importe,
                    'iva'               => 16,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);

                // 2. Insertar en catalogo_estudios usando el ID obtenido
                $codigoRaw = trim($record['codigo'] ?? '');
                $tiempoRaw = trim($record['tiempo_entrega'] ?? '');

                DB::table('catalogo_estudios')->insert([
                    'id'              => $productoServicioId, // Relación 1:1 compartiendo el ID
                    'codigo'          => is_numeric($codigoRaw) ? (int)$codigoRaw : null,
                    'nombre'          => trim($record['nombre'] ?? ''),
                    'tipo_estudio'    => trim($record['tipo_estudio'] ?? ''),
                    'departamento'    => trim($record['departamento'] ?? ''),
                    'tiempo_entrega'  => is_numeric($tiempoRaw) ? (int)$tiempoRaw : null,
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }

            if (is_resource($stream)) {
                fclose($stream);
            }            
        });
    }
}
