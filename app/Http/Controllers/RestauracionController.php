<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RestauracionController extends Controller
{
    /**
     * Muestra la vista de restauración.
     */
    public function showView()
    {
        return Inertia::render('db/respaldo/restauracion', [
            'success' => session('success'),
            'error'   => session('error')
        ]);
    }

    /**
     * Procesa el archivo SQL y restaura la base de datos.
     */
    public function restore(Request $request)
    {
        // 1. Validar el archivo
        $request->validate([
            'sql_file' => 'required|file|max:102400', // Máximo 100MB
        ], [
            'sql_file.required' => 'Debes seleccionar un archivo .sql.',
            'sql_file.max'      => 'El archivo es demasiado grande (máx 100MB).',
        ]);

        try {
            // 2. Obtener configuración de la base de datos
            $dbConfig = config('database.connections.mysql');
            
            // Forzar 127.0.0.1 es una buena práctica para evitar problemas con el socket local
            $dbHost = ($dbConfig['host'] === 'localhost' || $dbConfig['host'] === '127.0.0.1') 
                      ? '127.0.0.1' 
                      : $dbConfig['host'];

            $dbUser = $dbConfig['username'];
            $dbPass = $dbConfig['password'];
            $dbName = $dbConfig['database'];
            $dbPort = $dbConfig['port'];

            // 3. Obtener la ruta temporal del archivo subido
            $filePath = $request->file('sql_file')->getRealPath();

            // 4. Construir el comando para LINUX
            // Usamos comillas simples ('') para evitar que Bash interprete caracteres 
            // especiales en las contraseñas (como el símbolo $)
            $command = sprintf(
                "mysql --user='%s' --password='%s' --host='%s' --port='%s' '%s' < '%s'",
                $dbUser,
                $dbPass,
                $dbHost,
                $dbPort,
                $dbName,
                $filePath
            );

            // 5. Ejecutar el proceso. 
            // En Laravel 10+, Process::run() con un string automáticamente usa la shell 
            // del sistema (bash/sh), por lo que el operador de redirección '<' funcionará.
            $process = Process::timeout(300)->run($command);

            // 6. Verificar resultado
            if ($process->successful()) {
                Log::info("Base de datos restaurada con éxito por usuario ID: " . Auth::id());
                
                return to_route('bd.restauracion')
                    ->with('success', '¡La base de datos se ha restaurado correctamente!');
            } else {
                $errorOutput = $process->errorOutput();
                Log::error("Error restaurando BD: " . $errorOutput);

                // Adaptamos la validación de errores a la salida común de Linux
                if (str_contains(strtolower($errorOutput), 'command not found') || str_contains(strtolower($errorOutput), 'not found')) {
                    return to_route('bd.restauracion')
                        ->with('error', 'El servidor no encuentra el comando "mysql". Verifica que el cliente de MySQL esté instalado en tu servidor Linux.');
                }

                return to_route('bd.restauracion')
                    ->with('error', 'Error técnico al restaurar: ' . $errorOutput);
            }

        } catch (\Exception $e) {
            Log::error("Excepción en RestauracionController: " . $e->getMessage());
            
            return to_route('bd.restauracion')
                ->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}