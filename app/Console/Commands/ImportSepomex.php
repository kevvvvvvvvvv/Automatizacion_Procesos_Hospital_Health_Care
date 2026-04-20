<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSepomex extends Command
{
    protected $signature = 'sepomex:import';
    protected $description = 'Importa la base de datos de SEPOMEX a la tabla sepomex_data';

    public function handle()
    {
        $path = storage_path('app/sepomex.txt');

        if (!file_exists($path)) {
            $this->error("No se encontró el archivo en: {$path}");
            return;
        }

        $this->info('Iniciando importación de SEPOMEX...');
        
        DB::table('sepomex_data')->truncate();

        $handle = fopen($path, 'r');
        $batch = [];
        $contador = 0;

        while (($row = fgetcsv($handle, 0, '|')) !== false) {
            if (count($row) < 10 || strlen($row[0]) !== 5 || !ctype_digit($row[0])) {
                continue;
            }

            $batch[] = [
                'd_codigo'      => $row[0],
                'd_asenta'      => mb_convert_encoding($row[1], 'UTF-8', 'ISO-8859-1'),
                'd_tipo_asenta' => mb_convert_encoding($row[2], 'UTF-8', 'ISO-8859-1'),
                'D_mnpio'       => mb_convert_encoding($row[3], 'UTF-8', 'ISO-8859-1'),
                'd_estado'      => mb_convert_encoding($row[4], 'UTF-8', 'ISO-8859-1'),
                'd_ciudad'      => mb_convert_encoding($row[5], 'UTF-8', 'ISO-8859-1'),
                'c_estado'      => $row[7],
                'c_mnpio'       => $row[11],
                'created_at'    => now(),
                'updated_at'    => now(),
            ];

            if (count($batch) >= 1000) {
                DB::table('sepomex_data')->insertOrIgnore($batch);
                $contador += count($batch);
                $this->info("Registros importados: {$contador}...");
                $batch = [];
            }
        }

        if (!empty($batch)) {
            DB::table('sepomex_data')->insertOrIgnore($batch);
            $contador += count($batch);
        }

        fclose($handle);

        $this->newLine();
        $this->info("Se importaron {$contador} códigos postales.");
    }
}