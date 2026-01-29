<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

use App\Models\ProductoServicio;

class ProductoServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('medicamentos')->truncate();
        DB::table('insumos')->truncate();
        DB::table('producto_servicios')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::transaction(function () {
            
            $pathServicios = database_path('seeders/data/servicios.csv');
            
            if (file_exists($pathServicios)) {
                $this->command->info('Importando Servicios...');
                $csv = $this->leerCsv($pathServicios, ';');

                foreach ($csv->getRecords() as $record) {
                    if (empty($record['nombre_prestacion'])) continue;

                    DB::table('producto_servicios')->insert([
                        'tipo'              => 'SERVICIO',
                        'subtipo'           => $record['subtipo'] ?? 'GENERAL',
                        'codigo_prestacion' => $record['codigo_prestacion'] ?? null,
                        'nombre_prestacion' => $record['nombre_prestacion'],
                        'importe'           => $this->limpiarMoneda($record['importe'] ?? 0),
                        'iva'               => $this->limpiarMoneda($record['iva'] ?? 16),
                        'cantidad'          => null, 
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);
                }
            }

            $pathMedicamentos = database_path('seeders/data/medicamentos.csv');

            if (file_exists($pathMedicamentos)) {
                $this->command->info('Importando Medicamentos y Generando Catálogo de Vías...');
                $csv = $this->leerCsv($pathMedicamentos, ','); 

                foreach ($csv->getRecords() as $recordRaw) {
                    
                    $record = array_combine(array_map('trim', array_keys($recordRaw)), $recordRaw);

                    if (empty($record['nombre_comercial'])) continue;

                    $padreId = DB::table('producto_servicios')->insertGetId([
                        'tipo'              => 'INSUMOS',
                        'subtipo'           => 'MEDICAMENTOS',
                        'codigo_prestacion' => $record['codigo_barras'] ?? null,
                        'codigo_barras'     => $record['codigo_barras'] ?? null,
                        'nombre_prestacion' => $record['excipiente_activo_gramaje'] ?? $record['nombre_comercial'],
                        'importe'           => $this->limpiarMoneda($record['importe'] ?? 0),
                        'cantidad'          => (int)($record['cantidad'] ?? 0),
                        'iva'               => 0,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    $esFraccion = (in_array(strtoupper(trim($record['fraccion'] ?? '')), ['SI', 'S', '1']));
                    
                    $fechaCaducidad = null;
                    if (!empty($record['fecha_caducidad'])) {
                        try {
                            $fechaCaducidad = Carbon::parse($record['fecha_caducidad'])->format('Y-m-d');
                        } catch (\Exception $e) { $fechaCaducidad = null; }
                    }

                    DB::table('medicamentos')->insert([
                        'id' => $padreId,
                        'excipiente_activo_gramaje' => $record['excipiente_activo_gramaje'] ?? 'S/D',
                        'volumen_total'      => $this->limpiarMoneda($record['volumen_total'] ?? 0),
                        'nombre_comercial'   => $record['nombre_comercial'],
                        'gramaje'            => $record['gramaje'] ?? '',
                        'fraccion'           => $esFraccion,
                        'fecha_caducidad'    => $fechaCaducidad,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    
                    $viasRaw = $record['via_administracion'] ?? 'NO ESPECIFICADA';
                    $listaVias = explode(',', $viasRaw); 

                    foreach ($listaVias as $viaNombre) {
                        $viaLimpia = $this->normalizarVia($viaNombre);

                        if (empty($viaLimpia)) continue;

                        $catalogo = DB::table('catalogo_via_administracions')
                                    ->where('via_administracion', $viaLimpia)
                                    ->first();

                        if (!$catalogo) {
                            $catalogoId = DB::table('catalogo_via_administracions')->insertGetId([
                                'via_administracion' => $viaLimpia,
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        } else {
                            $catalogoId = $catalogo->id;
                        }

                        DB::table('medicamento_vias')->insert([
                            'medicamento_id' => $padreId,
                            'catalogo_via_administracion_id' => $catalogoId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            $pathInsumos = database_path('seeders/data/insumos.csv');

            if (file_exists($pathInsumos)) {
                $this->command->info('Importando Insumos...');
                $csv = $this->leerCsv($pathInsumos, ','); 

                foreach ($csv->getRecords() as $recordRaw) {

                    $record = array_combine(
                        array_map('trim', array_keys($recordRaw)),
                        $recordRaw
                    );

                    if (empty($record['categoria']) && empty($record['especificacion'])) continue;
                    $nombreInsumo = $record['nombre'] ?? ($record['categoria'] . ' ' . $record['especificacion']);

                    $padreId = DB::table('producto_servicios')->insertGetId([
                        'tipo'              => 'INSUMOS', 
                        'subtipo'           => 'GENERAL', 
                        'codigo_prestacion' => $record['codigo'] ?? null, 
                        'codigo_barras'     => $record['codigo_barras'] ?? null,
                        'nombre_prestacion' => $nombreInsumo,
                        
                        'importe'           => $this->limpiarMoneda($record['importe'] ?? 0.1),
                        'cantidad'          => (int)($record['Cantidad'] ?? 0),
                        
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    DB::table('insumos')->insert([
                        'id' => $padreId, 

                        'categoria'          => $record['categoria'] ?? 'General',
                        'especificacion'     => $record['especificacion'] ?? 'S/E',
                        'categoria_unitaria' => $record['categoria_unitaria'] ?? 'PZA', 
                        
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
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

    private function leerCsv($path, $delimiter = ',')
    {
        $stream = fopen($path, 'r');
        stream_filter_append($stream, 'convert.iconv.ISO-8859-1/UTF-8');
        
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter($delimiter); 
        $csv->setHeaderOffset(0);
        
        return $csv;
    }

    private function limpiarMoneda($valor)
    {
        if (is_null($valor) || $valor === '') return 0;
        return floatval(str_replace(['$', ',', '%'], '', $valor));
    }

    private function normalizarVia($texto)
    {
        $texto = strtoupper(trim($texto));

        $correcciones = [
            'INTRAVENOSO'   => 'INTRAVENOSA',
            'SUBCUTANEO'    => 'SUBCUTÁNEA', 
            'SUBCUTÁNEO'    => 'SUBCUTÁNEA',
            'OFTÁLMICO'     => 'OFTÁLMICA',
            'OFTALMICO'     => 'OFTÁLMICA',
            'OTOLÓGICO'     => 'OTOLÓGICA',
            'OTOLOGICO'     => 'OTOLÓGICA',
            'TOPICO'        => 'TÓPICA',
            'TÓPICO'        => 'TÓPICA',
            
            'SUBCUTANEA'    => 'SUBCUTÁNEA',
            'OFTALMICA'     => 'OFTÁLMICA',
            'DERMICA'       => 'DÉRMICA',
            'CUTANEA'       => 'CUTÁNEA',
            'TOPICA'        => 'TÓPICA',
            'INTRARTERIAL'  => 'INTRAARTERIAL', 
            'INFILTRACION'  => 'INFILTRACIÓN',
            'INFILTRACION LOCAL'     => 'INFILTRACIÓN LOCAL',
            'INFILTRACION TRONCULAR' => 'INFILTRACIÓN TRONCULAR',

        ];

        $textoCorregido = $correcciones[$texto] ?? $texto;

        if ($textoCorregido === 'REVISAR' || $textoCorregido === '') {
            return null;
        }

        return $textoCorregido;
    }
}