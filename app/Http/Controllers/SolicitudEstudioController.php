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
use App\Services\TwilioWhatsAppService;
use App\Services\PdfGeneratorService;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class SolicitudEstudioController extends Controller implements HasMiddleware
{
    protected $pdfGenerator;
    use AuthorizesRequests;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar solicitudes estudios', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear solicitudes estudios', only: ['create', 'store']),
            new Middleware($permission . ':editar solicitudes estudios', only: ['update','edit']),
            new Middleware($permission . ':eliminar solicitudes estudios', only: ['destroy']),
        ];
    }


    public function store(SolicitudEstudioRequest $request, Estancia $estancia, TwilioWhatsAppService $twilio)
    {
        $validatedData = $request->validated();
        DB::beginTransaction();
        try {
            $solicitud = $this->crearCabeceraSolicitud($request, $estancia);
            $itemsParaNotificar = $this->guardarItems($request, $solicitud);
            $this->procesarNotificaciones($solicitud, $itemsParaNotificar);
            $this->enviarRecordatorioCita($twilio);

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
            'userLlena',
            'itemable', 
            'formularioInstancia.estancia'
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

    public function update(Request $request, SolicitudEstudio $solicitudes_estudio)
    {
        $validated = $request->validate([
            'grupos' => 'required|array',
            'grupos.*.fecha_hora_grupo' => 'nullable|date',
            'grupos.*.problema_clinico' => 'nullable|string|max:500',
            'grupos.*.incidentes_accidentes' => 'nullable|string|max:500',

            'grupos.*.archivo_grupo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,xlsx,xls|max:10240', 
            
            'grupos.*.items' => 'required|array',
            'grupos.*.items.*.id' => 'required|exists:solicitud_items,id',
            'grupos.*.items.*.cancelado' => 'boolean',
        ]);

        $solicitudes_estudio->load('formularioInstancia.estancia');

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->grupos as $index => $grupoData) {
                    
                    $rutaArchivo = null;

                    // 2. Manejo de subida de archivos
                    // Nota: Accedemos usando el índice numérico del array
                    if ($request->hasFile("grupos.{$index}.archivo_grupo")) {
                        $archivo = $request->file("grupos.{$index}.archivo_grupo");
                        // Guardar en disco 'public' dentro de carpeta 'resultados'
                        $rutaArchivo = $archivo->store('resultados_estudios', 'public');
                    }

                    // 3. Actualizar cada Item (Estudio individual) dentro del grupo
                    foreach ($grupoData['items'] as $itemData) {
                        $item = SolicitudItem::findOrFail($itemData['id']);

                        if ($itemData['cancelado']) {
                            // CASO A: El estudio fue cancelado
                            $item->update([
                                'estado' => 'CANCELADO',
                                'fecha_realizacion' => now(),
                                //'notas_cancelacion' => 'Cancelado durante la entrega de resultados',
                            ]);
                        } else {
                            // CASO B: El estudio se realizó correctamente
                            
                            // Preparamos datos a actualizar
                            $datosActualizar = [
                                'estado' => 'FINALIZADO', // O 'ENTREGADO'
                                'fecha_realizacion' => $grupoData['fecha_hora_grupo'] ?? now(),
                                'problema_clinico' => $grupoData['problema_clinico'],
                                'incidentes_accidentes' => $grupoData['incidentes_accidentes'],
                            ];

                            // Solo actualizamos la ruta del archivo si se subió uno nuevo
                            // Si no, mantenemos el anterior (si existía)
                            if ($rutaArchivo) {
                                $datosActualizar['ruta_archivo_resultado'] = $rutaArchivo;
                                $datosActualizar['estado'] = 'FINALIZADO';
                            }

                            $item->update($datosActualizar);
                        }
                    }
                }
                
                // Opcional: Actualizar estatus general de la solicitud padre
                // $solicitud_estudio->update(['estatus' => 'COMPLETADO']);
            });

            return redirect()->route('estancias.show',$solicitudes_estudio->formularioInstancia['estancia_id'])
                ->with('success', 'Resultados guardados correctamente.');            

        }catch(\Exception $e){
            Log::error('Error al registrar los resultados de los estudios: ', $e->getMessage());
            return Redirect::back()->with('error','Error al registrar los resultados de los estudios.');
        }
    }

    public function show(SolicitudEstudio $solicitudes_estudio)
    {
        $solicitudes_estudio->load(
            'userSolicita',
            'userLlena',
            'solicitudItems.catalogoEstudio',
            'solicitudItems.userRealiza',
            'formularioInstancia.estancia',
        );

        return Inertia::render('estudios/items/index', [
            'solicitud' => $solicitudes_estudio,
            
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

        $headerData = [
            'historiaclinica' => $solicitudes_estudio,
            'paciente' => $solicitudes_estudio->formularioInstancia->estancia->paciente,
            'estancia' => $solicitudes_estudio->formularioInstancia->estancia
        ];

        $viewData = [
            'notaData' => $solicitudes_estudio,
            'paciente' => $solicitudes_estudio->formularioInstancia->estancia->paciente,
            'medico' => $solicitudes_estudio->formularioInstancia->user,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.solicitud-estudio',
            $viewData,
            $headerData,
            'solicitud-estudios-',
            $solicitudes_estudio->id
        );
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
        $solicitud->itemable_id = $request->itemable_id;
        $solicitud->itemable_type= $request->itemable_type;

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
                    'estado' => 'SOLICITADO'
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
                        'estado' => 'SOLICITADO'
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
            'RESONANCIA MAGNÉTICA' => User::all(),

            default => User::role('administrador')->get(),
        };
    }

    public function enviarRecordatorioCita(TwilioWhatsAppService $twilio)
    {
        $numeroCliente = '+5217774571517'; 
        
        $fecha = '2025-12-28';
        $hora = '10:00 AM';

        $mensaje = "Your appointment is coming up on $fecha at $hora";

        $twilio->sendMessage($numeroCliente, $mensaje);

        return "Notificación de cita enviada (En inglés por Sandbox)";
    }

}
