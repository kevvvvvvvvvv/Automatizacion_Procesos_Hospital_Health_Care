<?php


namespace App\Http\Controllers;

use App\Models\Backups;

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

        return Inertia::render('BD/Respaldo/index', [
            'backups' => $backups,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function store(Request $request)
{
    // Auth::id() siempre obtiene la PK, no importa si se llama id o idUsuario
    $id = Auth::id(); 

    if (!$id) {
        return back()->with('error', 'Sesión no válida o expirada.');
    }
    //dd($id);
    GenerarBackupJob::dispatch((int)$id);

    return to_route('respaldo.index')
        ->with('success', 'Tu respaldo se está generando...');
}

    public function download(Backup $backup)
    {
        if ($backup->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        if ($backup->status !== 'completed') {
            return to_route('bd.respaldo.index')
                ->with('error', 'Este respaldo aún no está listo o ha fallado.');
        }
        $fullPath = storage_path('app/' . $backup->path);

        if (!Storage::disk('local')->exists($backup->path)) {
             return to_route('respaldo.index')
                ->with('error', 'El archivo del respaldo no se ha encontrado en el servidor.');
        }

        return response()->download($fullPath, $backup->file_name);
    }
}