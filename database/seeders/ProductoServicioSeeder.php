<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Carbon\Carbon;

class ProductoServicioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. LIMPIEZA (FUERA DE LA TRANSACCIÓN)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('medicamentos')->truncate();
        DB::table('insumos')->truncate();
        DB::table('producto_servicios')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. INSERCIÓN (DENTRO DE LA TRANSACCIÓN)
        DB::transaction(function () {
            
            // --- A. IMPORTAR SERVICIOS ---
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
                $csv = $this->leerCsv($pathMedicamentos, ','); // <--- Ojo con tu delimitador

                foreach ($csv->getRecords() as $recordRaw) {
                    // Limpieza de llaves del CSV
                    $record = array_combine(array_map('trim', array_keys($recordRaw)), $recordRaw);

                    if (empty($record['nombre_comercial'])) continue;

                    // A. INSERTAR PADRE (ProductoServicio)
                    $padreId = DB::table('producto_servicios')->insertGetId([
                        'tipo'              => 'INSUMOS',
                        'subtipo'           => 'MEDICAMENTOS',
                        'codigo_prestacion' => $record['codigo_barras'] ?? null,
                        'codigo_barras'     => $record['codigo_barras'] ?? null,
                        'nombre_prestacion' => $record['excipiente_activo_gramaje'] ?? $record['nombre_comercial'],
                        'importe'           => $this->limpiarMoneda($record['importe'] ?? 0),
                        'cantidad'          => (int)($record['cantidad'] ?? 0),
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    // B. DATOS DEL HIJO (Medicamento)
                    $esFraccion = (in_array(strtoupper(trim($record['fraccion'] ?? '')), ['SI', 'S', '1']));
                    
                    $fechaCaducidad = null;
                    if (!empty($record['fecha_caducidad'])) {
                        try {
                            $fechaCaducidad = Carbon::parse($record['fecha_caducidad'])->format('Y-m-d');
                        } catch (\Exception $e) { $fechaCaducidad = null; }
                    }

                    // C. INSERTAR HIJO (Medicamentos)
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

                    // -------------------------------------------------------
                    // D. LA MAGIA: PROCESAR VÍAS DE ADMINISTRACIÓN
                    // -------------------------------------------------------
                    
                    // 1. Obtener el texto crudo: ej "Oral, Intravenoso"
                    $viasRaw = $record['via_administracion'] ?? 'NO ESPECIFICADA';
                    
                    // 2. Separar por comas (explode) para tener un array
                    $listaVias = explode(',', $viasRaw); 

                    foreach ($listaVias as $viaNombre) {
                        // 3. Limpiar la palabra individual
                        $viaLimpia = $this->normalizarVia($viaNombre);

                        if (empty($viaLimpia)) continue;

                        // 4. Buscar o Crear en el Catálogo (Evita duplicados)
                        // Esto llena tu tabla 'catalogo_via_administracions' automáticamente
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

                        // 5. Crear la relación en la tabla Pivote
                        DB::table('medicamento_vias')->insert([
                            'medicamento_id' => $padreId,
                            'catalogo_via_administracion_id' => $catalogoId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // ---------------------------------------------------------
            // PARTE 3: IMPORTAR INSUMOS
            // ---------------------------------------------------------
            $pathInsumos = database_path('seeders/data/insumos.csv');

            if (file_exists($pathInsumos)) {
                $this->command->info('Importando Insumos...');
                // Ajusta el delimitador (',' o ';') según tu archivo
                $csv = $this->leerCsv($pathInsumos, ','); 

                foreach ($csv->getRecords() as $recordRaw) {
                    
                    // 1. LIMPIEZA DE LLAVES (Quita espacios invisibles)
                    $record = array_combine(
                        array_map('trim', array_keys($recordRaw)),
                        $recordRaw
                    );

                    // Validación básica: Si no tiene categoría o especificación, saltamos
                    if (empty($record['categoria']) && empty($record['especificacion'])) continue;

                    // 2. CONSTRUIR NOMBRE DEL PRODUCTO
                    // A veces los insumos no tienen "Nombre Comercial". 
                    // Si el CSV trae nombre úsalo, si no, lo armamos: "Jeringa - 5ml"
                    $nombreInsumo = $record['nombre'] ?? ($record['categoria'] . ' ' . $record['especificacion']);

                    // 3. INSERTAR PADRE (ProductoServicios)
                    $padreId = DB::table('producto_servicios')->insertGetId([
                        'tipo'              => 'INSUMOS', // Tipo general
                        'subtipo'           => 'GENERAL', // O lo que prefieras
                        'codigo_prestacion' => $record['codigo'] ?? null, // Si tienes código en el CSV
                        'codigo_barras'     => $record['codigo_barras'] ?? null,
                        'nombre_prestacion' => $nombreInsumo,
                        
                        // Precios y Stock (Padre)
                        'importe'           => $this->limpiarMoneda($record['importe'] ?? 0.1),
                        'cantidad'          => (int)($record['Cantidad'] ?? 0),
                        
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    // 4. INSERTAR HIJO (Insumos)
                    DB::table('insumos')->insert([
                        'id' => $padreId, // <--- Vinculación
                        
                        // Campos específicos que me pasaste:
                        'categoria'          => $record['categoria'] ?? 'General',
                        'especificacion'     => $record['especificacion'] ?? 'S/E',
                        'categoria_unitaria' => $record['categoria_unitaria'] ?? 'PZA', // Pieza por defecto
                        
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }

    private function leerCsv($path, $delimiter = ',')
    {
        $stream = fopen($path, 'r');
        stream_filter_append($stream, 'convert.iconv.ISO-8859-1/UTF-8');
        
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter($delimiter); // <--- Aquí usamos el que le enviamos
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
        // 1. Convertir a Mayúsculas y quitar espacios
        $texto = strtoupper(trim($texto));

        // 2. Diccionario de Correcciones (MAL ESCRITO => BIEN ESCRITO)
        $correcciones = [
            // Errores de Género (Masculino -> Femenino)
            'INTRAVENOSO'   => 'INTRAVENOSA',
            'SUBCUTANEO'    => 'SUBCUTÁNEA', // Corrige género y acento
            'SUBCUTÁNEO'    => 'SUBCUTÁNEA',
            'OFTÁLMICO'     => 'OFTÁLMICA',
            'OFTALMICO'     => 'OFTÁLMICA',
            'OTOLÓGICO'     => 'OTOLÓGICA',
            'OTOLOGICO'     => 'OTOLÓGICA',
            'TOPICO'        => 'TÓPICA',
            'TÓPICO'        => 'TÓPICA',
            
            // Faltas de Ortografía / Acentos faltantes
            'SUBCUTANEA'    => 'SUBCUTÁNEA',
            'OFTALMICA'     => 'OFTÁLMICA',
            'DERMICA'       => 'DÉRMICA',
            'CUTANEA'       => 'CUTÁNEA',
            'TOPICA'        => 'TÓPICA',
            'INTRARTERIAL'  => 'INTRAARTERIAL', // Corrección ortográfica
            'INFILTRACION'  => 'INFILTRACIÓN',
            'INFILTRACION LOCAL'     => 'INFILTRACIÓN LOCAL',
            'INFILTRACION TRONCULAR' => 'INFILTRACIÓN TRONCULAR',

        ];

        // 3. Aplicar corrección si existe
        $textoCorregido = $correcciones[$texto] ?? $texto;

        // 4. FILTRO DE BASURA: Si es "REVISAR" o está vacío, retornamos null
        if ($textoCorregido === 'REVISAR' || $textoCorregido === '') {
            return null;
        }

        return $textoCorregido;
    }
}