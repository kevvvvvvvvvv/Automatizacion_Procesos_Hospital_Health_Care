<?php

namespace App\Http\Controllers\BackupsRestauration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RestaurationController extends Controller
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
        $request->validate([
            'sql_file' => 'required|file|max:102400', 
        ], [
            'sql_file.required' => 'Debes seleccionar un archivo .sql.',
            'sql_file.max'      => 'El archivo es demasiado grande (máx 100MB).',
        ]);

        try {

            $dbConfig = config('database.connections.mysql');
            

            $dbHost = ($dbConfig['host'] === 'localhost' || $dbConfig['host'] === '127.0.0.1') 
                      ? '127.0.0.1' 
                      : $dbConfig['host'];

            $dbUser = $dbConfig['username'];
            $dbPass = $dbConfig['password'];
            $dbName = $dbConfig['database'];
            $dbPort = $dbConfig['port'];

            $filePath = $request->file('sql_file')->getRealPath();

            $command = sprintf(
                'mysql --user="%s" --password="%s" --host="%s" --port="%s" "%s" < "%s"',
                $dbUser,
                $dbPass,
                $dbHost,
                $dbPort,
                $dbName,
                $filePath
            );

            $fullCommand = "cmd /c $command";
            $process = Process::timeout(300)->run($fullCommand);

            if ($process->successful()) {
                Log::info("Base de datos restaurada con éxito por usuario ID: " . Auth::id());
                
                return to_route('bd.restauracion')
                    ->with('success', '¡La base de datos se ha restaurado correctamente!');
            } else {
                $errorOutput = $process->errorOutput();
                Log::error("Error restaurando BD: " . $errorOutput);

                if (str_contains($errorOutput, 'not found') || str_contains($errorOutput, 'no se reconoce')) {
                    return to_route('bd.restauracion')
                        ->with('error', 'El sistema no encuentra el ejecutable "mysql". Verifica que esté en el PATH de Windows.');
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
