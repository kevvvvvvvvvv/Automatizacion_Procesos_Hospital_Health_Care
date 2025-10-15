<?php

namespace App\Console\Commands;

use App\Models\CatalogoPregunta;
use Illuminate\Console\Command;

class DebugPreguntas extends Command
{
    protected $signature = 'debug:preguntas';
    protected $description = 'Verifica la validez del JSON en la tabla catalogo_preguntas';

    public function handle()
    {
        $this->info('Iniciando verificación de campos_adicionales...');
        $problemaEncontrado = false;

        $preguntas = CatalogoPregunta::all();

        foreach ($preguntas as $pregunta) {

            $jsonCrudo = $pregunta->getAttributes()['campos_adicionales'];

            if ($jsonCrudo !== null) {

                json_decode($jsonCrudo);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->error("¡PROBLEMA ENCONTRADO!");
                    $this->line("La pregunta con ID: <fg=yellow>{$pregunta->id}</> ('{$pregunta->pregunta}') tiene JSON inválido.");
                    $this->line("Contenido crudo: <fg=gray>{$jsonCrudo}</>");
                    $problemaEncontrado = true;
                }
            }
        }

        if (!$problemaEncontrado) {
            $this->info('Verificación completada. No se encontraron errores de sintaxis en el JSON.');
        }

        return 0;
    }
}