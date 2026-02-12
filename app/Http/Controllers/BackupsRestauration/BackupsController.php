<?php


namespace App\Http\Controllers\BackupsRestauration;
use App\Http\Controllers\Controller;

use App\Models\BackupsRestauration\Backups;
use App\Jobs\GenerarBackupJob;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class BackupsController extends Controller
{
    public function index()
    {
        $backups = Auth::user()->backups()
                        ->latest() 
                        ->get();

        return Inertia::render('db/respaldo/index', [
            'backups' => $backups,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function store(Request $request)
    {
        $id = Auth::id(); 

        if (!$id) {
            return back()->with('error', 'Sesión no válida o expirada.');
        }
        GenerarBackupJob::dispatch((int)$id);

        return to_route('respaldo.index')
            ->with('success', 'Tu respaldo se está generando...');
    }

    public function download(Backups $backup)
    {
        if ($backup->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para descargar este respaldo.');
        }

        $filePath = storage_path( $backup->path);
        \Log::info("Buscando archivo en: " . $filePath);
        $filePath = storage_path($backup->path );

        if (!file_exists($filePath)) {
            return back()->with('error', 'El archivo físico no se encuentra en el servidor.');
        }

        // 4. Retornar la descarga
        return response()->download($filePath, $backup->file_name);
    }
}