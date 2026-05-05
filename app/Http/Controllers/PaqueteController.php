<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;

use App\Services\PdfGeneratorService;

use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use App\Models\Estudio\SolicitudEstudio;
use App\Models\Formulario\Paquete\Paquete; 
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Inventario\ProductoServicio;
use App\Models\Venta\Venta;
use App\Models\User;
use App\Services\VentaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use Carbon\Carbon;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Inertia\Inertia;

class PaqueteController extends Controller
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
    public function create(Paciente $paciente, Estancia $estancia)
    {

        //dd($estancia->toArray());
        return Inertia::render('formularios/paquetes/create', [
            'estancia' => $estancia,
            'hojaenfermeria' => $estancia->hojaEnfermeria,
            'catalogoEstudios' => CatalogoEstudio::all(),
            'modeloTipo' => 'App\Models\Estancia',
        ]);
    }
   public function show(SolicitudEstudio $paquete) 
{
    $paquete->load([
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user',
        'paquetes.catalogoEstudio', 
        'userSolicita'
    ]);

    return Inertia::render('formularios/paquetes/show', [
        'paciente'  => $paquete->formularioInstancia->estancia->paciente,
        'estancia'  => $paquete->formularioInstancia->estancia,
        'solicitud' => $paquete, 
    ]);
}

  public function store(Request $request, Paciente $paciente, Estancia $estancia, VentaService $ventaService)
{
    $request->validate([
        'user_solicita_id' => 'required|exists:users,id',
        'estudios_agregados_ids' => 'nullable|array',
        'estudios_adicionales' => 'nullable|array',
        // Validamos que los signos sean opcionales pero consistentes
        'ta_sistolica' => 'nullable|string',
        'ta_diastolica' => 'nullable|string',
        'fc' => 'nullable|string',
        'fr' => 'nullable|string',
        'temp' => 'nullable|string',
        'so2' => 'nullable|string',
        'glucemia' => 'nullable|string',
        'peso' => 'nullable|string',
        'talla' => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        // 1. Crear Instancia Maestra
        $instanciaMaestra = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_PAQUETES, 
            'user_id' => Auth::id(),
        ]);

        // 2. Crear Cabecera de Solicitud
        $solicitud = SolicitudEstudio::create([
            'id'               => $instanciaMaestra->id, 
            'user_llena_id'    => Auth::id(),
            'user_solicita_id' => $request->user_solicita_id,
            'itemable_id'      => $estancia->id,
            'itemable_type'    => 'App\Models\Estancia',
        ]);

        $itemsParaNotificar = collect();

        // --- PREPARAMOS LOS DATOS DE SIGNOS VITALES ---
        $datosSignos = [
            'ta_sistolica'  => $request->ta_sistolica,
            'ta_diastolica' => $request->ta_diastolica,
            'fc'            => $request->fc,
            'fr'            => $request->fr,
            'temp'          => $request->temp,
            'so2'           => $request->so2,
            'glucemia'      => $request->glucemia,
            'peso'          => $request->peso,
            'talla'         => $request->talla,
        ];

        // 3. Procesar Estudios del Catálogo
        if ($request->filled('estudios_agregados_ids')) {
            foreach ($request->estudios_agregados_ids as $catalogoId) {
                $estudioDb = CatalogoEstudio::find($catalogoId);
                
                if ($estudioDb) {
                    // Combinamos los datos base del paquete con los signos vitales
                    $item = Paquete::create(array_merge([
                        'formulario_instancia_id' => $instanciaMaestra->id,
                        'solicitud_estudio_id'    => $solicitud->id,
                        'catalogo_estudio_id'     => $catalogoId,
                        'departamento_destino'    => $estudioDb->departamento ?? 'GENERAL',
                        'estado'                  => 'SOLICITADO',
                    ], $datosSignos)); // <--- AQUÍ SE INSERTAN LOS SIGNOS
                    
                    $itemsParaNotificar->push($item);
                    $this->registrarVentaItem($ventaService, $estancia, $catalogoId);
                }
            }
        }

        // 5. Procesar Estudios Manuales
        if ($request->filled('estudios_adicionales')) {
            foreach ($request->estudios_adicionales as $manual) {
                $nombre = is_array($manual) ? ($manual['nombre'] ?? 'Estudio') : $manual;
                
                $itemManual = Paquete::create(array_merge([
                    'formulario_instancia_id' => $instanciaMaestra->id,
                    'solicitud_estudio_id'    => $solicitud->id,
                    'catalogo_estudio_id'     => null,
                    'otro_estudio'            => $nombre,
                    'departamento_destino'    => 'GENERAL',
                    'estado'                  => 'SOLICITADO',
                ], $datosSignos)); // <--- TAMBIÉN PARA LOS MANUALES
                
                $itemsParaNotificar->push($itemManual);
            }
        }

        if ($itemsParaNotificar->isNotEmpty()) {
            $this->notificarDepartamentos($solicitud, $itemsParaNotificar);
        }

        DB::commit();
        
        return Redirect::route('paquetes.show', $solicitud->id)
            ->with('success', 'Solicitud creada con signos vitales.');

    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Error en PaqueteController@store: ' . $e->getMessage());
        return Redirect::back()->with('error', 'Error: ' . $e->getMessage());
    }
}

   private function registrarVentaItem(VentaService $ventaService, Estancia $estancia, $catalogo_estudio_id)
{
    // 1. Obtenemos el estudio del catálogo para saber qué estamos buscando
    $estudio = CatalogoEstudio::find($catalogo_estudio_id);
    if (!$estudio) return;

    // 2. Buscamos en producto_servicios por nombre_prestacion
    $producto = ProductoServicio::where('nombre_prestacion', $estudio->nombre)->first();

    if (!$producto) {
        Log::warning("No se encontró un producto/servicio con el nombre: " . $estudio->nombre);
        return;
    }

    // 3. Buscamos si ya hay una venta pendiente para esta estancia
    $ventaExistente = Venta::where('estancia_id', $estancia->id)
        ->where('estado', Venta::ESTADO_PENDIENTE)
        ->first();

    $itemVenta = [
        'id'       => $producto->id,
        'cantidad' => 1,
        'tipo'     => 'servicio',
        'nombre'   => $producto->nombre_prestacion,
        'precio'   => $producto->importe, // Usamos 'importe' según tu migración
    ];

    if ($ventaExistente) {
        $ventaService->addItemToVenta($ventaExistente, $itemVenta);
    } else {
        $ventaService->crearVenta([$itemVenta], $estancia->id, Auth::id());
    }
}

    private function notificarDepartamentos($solicitud, $items)
    {
        $paciente = $solicitud->formularioInstancia->estancia->paciente;
        $grupos = $items->groupBy('departamento_destino');

        foreach ($grupos as $depto => $itemsGrupo) {
            $usuarios = $this->obtenerUsuariosPorDepto($depto);
            foreach ($usuarios as $user) {
                // Aquí asumo que tienes tu notificación creada
                // $user->notify(new NuevaSolicitudEstudios($itemsGrupo, $paciente, $solicitud->id));
            }
        }
    }

    private function obtenerUsuariosPorDepto($departamento)
    {
        $d = mb_strtoupper($departamento, 'UTF-8');
        return match (true) {
            str_contains($d, 'LABORATORIO') => User::role('técnico de laboratorio')->get(),
            str_contains($d, 'RAYOS') || str_contains($d, 'ULTRA') => User::role('radiólogo')->get(),
            default => User::role('administrador')->get(),
        };
    }
  public function generarPdf()
    {
        $data = [
            'fecha_hoy' => date('d/m/Y'),
            'folio'     => 'S/F',
            'paciente'  => null, 
            'tutor'     => null,
        ];

    return Pdf::view('pdfs.paquetes', $data)
        ->withBrowsershot(function (Browsershot $browsershot) {
            $chromePath = config('services.browsershot.chrome_path');
            if ($chromePath) {
                $browsershot->setChromePath($chromePath);
                $browsershot->noSandbox();
                $browsershot->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                ]);
            } else {

            }
        })
        ->name('paquetes' . date('Y-m-d') . '.pdf');
}


protected function configureBrowsershot(Browsershot $browsershot)
{
    $chromePath = config('services.browsershot.chrome_path');
    if ($chromePath) {
        $browsershot->setChromePath($chromePath);
        $browsershot->noSandbox();
        $browsershot->addChromiumArguments([
            'disable-dev-shm-usage',
            'disable-gpu',
        ]);
    }
}
}