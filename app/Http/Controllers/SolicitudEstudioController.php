<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudEstudioRequest;
use Illuminate\Http\Request;

use App\Models\Estancia;
use App\Models\FormularioInstancia; 
use App\Models\SolicitudEstudio;
use App\Models\SolicitudItem;
use Illuminate\Support\Facades\Auth;
use App\Models\FormularioCatalogo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\NuevaSolicitudEstudios;
use Inertia\Inertia;

class SolicitudEstudioController extends Controller
{
    public function store(SolicitudEstudioRequest $request, Estancia $estancia)
    {
        
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $solicitud = $this->crearCabeceraSolicitud($request, $estancia);
            $itemsParaNotificar = $this->guardarItems($request, $solicitud);
            $this->procesarNotificaciones($solicitud, $itemsParaNotificar);

            DB::commit();
            return Redirect::back()->with('success', 'Solicitud creada y notificada.');

        } catch (\Exception $e) {

            DB::rollback();
            Log::error('Error al crear la solicitud de estudios: '. $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitud de estudios');
        }
    }

    public function edit(SolicitudEstudio $solicitudes_estudio)
    {
        $solicitudes_estudio->load([
            'solicitudItems.catalogoEstudio', 
            'userSolicita',
            'userLlena' 
        ]);
        
        $personal = User::all();
        $user = Auth::user();
        
        $grupoLaboratorio = [
            'BACTEROLOGÍA', 'COAGULACIÓN', 'HEMATOLOGÍA', 'HORMONAS',
            'OTROS ESTUDIOS Y/O PERFILES', 'PARASITOLOGÍA', 'QUÍMICA CLÍNICA',
            'SEMINOGRAMA', 'UROANÁLISIS', 'LABORATORIO' 
        ];

        $departamentosPermitidos = match(true) {
            $user->hasRole('técnico de laboratorio') => $grupoLaboratorio,
            $user->hasRole('administrador') => ['*'], 
            default => [] 
        };

        $itemsFiltrados = $solicitudes_estudio->solicitudItems->filter(function ($item) use ($departamentosPermitidos) {
            if (in_array('*', $departamentosPermitidos)) return true;
            
            $depto = $item->catalogoEstudio->departamento 
                    ?? $item->detalles['departamento_manual'] 
                    ?? 'GENERAL';
            
            return in_array(mb_strtoupper($depto, 'UTF-8'), $departamentosPermitidos);
        });

        $grupos = $itemsFiltrados->groupBy(function ($item) use ($grupoLaboratorio) {
            $nombreReal = $item->catalogoEstudio->departamento 
                        ?? $item->detalles['departamento_manual'] 
                        ?? 'GENERAL';
            
            $nombreMayus = mb_strtoupper($nombreReal, 'UTF-8');
            if (in_array($nombreMayus, $grupoLaboratorio)) {
                return 'LABORATORIO';
            }
            return $nombreMayus;
        });

        $gruposFormatted = [];
        foreach ($grupos as $nombreGrupo => $items) {
            $gruposFormatted[] = [
                'nombre_grupo' => $nombreGrupo,
                'items' => $items->values()
            ];
        }

        return Inertia::render('estudios/resultados', [
            'solicitud_estudio' => $solicitudes_estudio,
            'grupos_estudios' => $gruposFormatted,
            'personal' => $personal,
        ]);
    }

    public function generarPDF(SolicitudEstudio $solicitudes_estudio)
    {
        $solicitudes_estudio->load(
            'userSolicita',
            'userLlena',
            'solicitudItems.catalogoEstudio',
            'formularioInstancia.estancia.paciente'
        ); 

        //dd($solicitudes_estudio->toArray());
        return Pdf::view('pdfs.solicitud-estudio',['solicitud' => $solicitudes_estudio])
            ->withBrowsershot(function (Browsershot $browsershot){
                $chromePath = config('services.browsershot.chrome_path');
                if ($chromePath) {
                    $browsershot->setChromePath($chromePath);
                    $browsershot->noSandbox();
                    $browsershot->addChromiumArguments([
                        'disable-dev-shm-usage',
                        'disable-gpu',
                    ]);
                }
            })
            ->inline('solicitud examen.pdf');
            
    }

    private function crearCabeceraSolicitud($request, $estancia)
    {
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),  
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS, 
            'user_id' => Auth::id(),
        ]);
        
        $solicitud = new SolicitudEstudio();
        $solicitud->id = $formularioInstancia->id;
        $solicitud->user_llena_id = Auth::id();
        $solicitud->user_solicita_id = $request->user_solicita_id;
        $solicitud->problemas_clinicos = $request->diagnostico_problemas;
        $solicitud->incidentes_accidentes = $request->incidentes_accidentes;
        $solicitud->save();

        return $solicitud;
    }

    private function guardarItems($request, $solicitud)
    {
        $itemsCollection = collect();
        $detallesArray = $request->input('detallesEstudios', []);

        if (!empty($request->estudios_agregados_ids)) {
            foreach ($request->estudios_agregados_ids as $catalogoId) {
                $item = SolicitudItem::create([
                    'solicitud_estudio_id' => $solicitud->id,
                    'catalogo_estudio_id' => $catalogoId,
                    'detalles' => $detallesArray[$catalogoId] ?? null,
                    'otro_estudio' => null, 
                    'estado' => 'solicitado'
                ]);
                $itemsCollection->push($item);
            }
        }

        if (!empty($request->estudios_adicionales)) {
            foreach ($request->estudios_adicionales as $itemManual) {
                if (is_array($itemManual)) {
                    $item = SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => null, 
                        'otro_estudio' => $itemManual['nombre'], 
                        'detalles' => ['departamento_manual' => $itemManual['departamento'] ?? 'GENERAL'], 
                        'estado' => 'solicitado'
                    ]);
                    $itemsCollection->push($item);
                }
            }
        }

        return $itemsCollection;
    }

    private function procesarNotificaciones($solicitud, $items)
    {
        if ($items->isEmpty()) return;
        $items = new \Illuminate\Database\Eloquent\Collection($items);
        $items->load('catalogoEstudio');

        $paciente = $solicitud->formularioInstancia->estancia->paciente;

        $grupos = $items->groupBy(function ($item) {
            if ($item->catalogoEstudio) {
                return $item->catalogoEstudio->departamento ?? 'GENERAL';
            }
            return $item->detalles['departamento_manual'] ?? 'GENERAL';
        });

        foreach ($grupos as $departamento => $itemsDelGrupo) {
            $usuariosDestino = $this->obtenerDestinatariosPorDepartamento($departamento);
            $segundosEspera = 0;

            if ($usuariosDestino->isNotEmpty()) {
                
                /** @var \App\Models\User $usuario */
                foreach ($usuariosDestino as $usuario) {
                    $usuario->notify(
                        (new NuevaSolicitudEstudios($itemsDelGrupo, $paciente, $solicitud->id))
                        ->delay(now()->addSeconds($segundosEspera))
                    );
                    $segundosEspera += 5;
                }
            }
        }
    }


    private function obtenerDestinatariosPorDepartamento($departamento)
    {
        $depto = mb_strtoupper($departamento, 'UTF-8');

        return match ($depto) {
            
            // --- GRUPO: LABORATORIO ---
            'BACTEROLOGÍA',
            'COAGULACIÓN',
            'HEMATOLOGÍA',
            'HORMONAS',
            'PARASITOLOGÍA',
            'QUÍMICA CLÍNICA',
            'SEMINOGRAMA',
            'UROANÁLISIS',
            'OTROS ESTUDIOS Y/O PERFILES' => User::role('técnico de laboratorio')->get(),

            // --- GRUPO: RAYOS X / IMAGENOLOGÍA ---
            'RADIOLOGÍA GENERAL',
            'TOMOGRAFÍA COMPUTADA',
            'ULTRASONIDO' => User::role('técnico radiólogo')->get(),

            // --- GRUPO: RESONANCIA (O puedes unirlo al anterior) ---
            'RESONANCIA MAGNÉTICA' => User::role(['Radiologo', 'Jefe Imagenologia'])->get(),

            default => User::role('administrador')->get(),
        };
    }
}
