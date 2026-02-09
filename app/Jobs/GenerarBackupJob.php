<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\BackupsRestauration\Backups;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenerarBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $userId;

    /**
     * @param int $userId
     */
    public function __construct(?int $userId)
    {
        $this->userId = $userId;
    }


    public function handle(): void
    {
        try {
            $user = User::findOrFail($this->userId);

            
            } catch (\Exception $e) {
                Log::error("Job de backup falló: No se pudo encontrar al usuario con ID {$this->userId}");
                return; 
            }
        
            $backupDir = storage_path('backups');
            $fileName = 'backup-' . $user->id . '-' . now()->format('Y-m-d-His') . '.sql';
            $storagePath = 'backups/' . $fileName;

            $backupRecord = Backups::create([
                'user_id' => $user->id,
                'file_name' => $fileName,
                'path' => $storagePath,
                'status' => 'pending',
            ]);

            try {
            File::ensureDirectoryExists($backupDir);

            $dbConfig = config('database.connections.mysql');
            
            $dumpPath = '/usr/bin/mariadb-dump'; 

            $backupFullPath = storage_path( $storagePath);

            $process = Process::run([
                $dumpPath,
                "-u{$dbConfig['username']}",
                "-p{$dbConfig['password']}",
                "-h{$dbConfig['host']}",
                "-P{$dbConfig['port']}",
                $dbConfig['database']
            ]);

            if ($process->successful()) {
                File::put($backupFullPath, $process->output());
                
                $backupRecord->update(['status' => 'completed']);
            } else {
                Log::error("Error de MariaDB: " . $process->errorOutput());
                $backupRecord->update(['status' => 'failed']);
            }

        } catch (\Exception $e) {
            Log::error("Excepción en Job: " . $e->getMessage());
            $backupRecord->update(['status' => 'failed']);
        }
    }
}