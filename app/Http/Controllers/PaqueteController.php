<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Estudio\SolicitudEstudio;
use App\Models\Formulario\Paquete\Paquete; 
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Inventario\ProductoServicio;
use App\Models\Venta\Venta;
use App\Models\User;
use App\Services\VentaService;
use App\Services\PdfGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PaqueteController extends Controller //implements HasMiddleware
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * Definición de Middlewares para el controlador (Laravel 11+)
     */
   /* public static function middleware(): array
    {
        return [
            new Middleware('permission:consultar solicitudes estudios', only: ['index', 'show']),
            new Middleware('permission:crear solicitudes estudios', only: ['create', 'store']),
            new Middleware('permission:editar solicitudes estudios', only: ['update', 'edit']),
            new Middleware('permission:eliminar solicitudes estudios', only: ['destroy']),
        ];
    }
*/
    public function create(Paciente $paciente, Estancia $estancia)
    {
        

        return Inertia::render('formularios/paquetes/create', [
            'paciente' => $paciente,
            'estancia' => $estancia->load('paciente'),
            'catalogoEstudios' => CatalogoEstudio::all(),
            'medicos' => User::role('medico')->get(),
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
        'paciente' => $paquete->formularioInstancia->estancia->paciente,
        'estancia' => $paquete->formularioInstancia->estancia,
        'solicitud' => $paquete,
    ]);
}

    public function store(Request $request, Paciente $paciente, Estancia $estancia, VentaService $ventaService)
    {
        $request->validate([
            'user_solicita_id' => 'required|exists:users,id',
            'estudios_agregados_ids' => 'array',
            'estudios_adicionales' => 'array',
        ]);

        DB::beginTransaction(); 
        try {
            $instanciaCabecera = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_PAQUETES,
                'user_id' => Auth::id(),
            ]);

            $solicitud = SolicitudEstudio::create([
                'id' => $instanciaCabecera->id,
                'user_llena_id' => Auth::id(),
                'user_solicita_id' => $request->user_solicita_id,
                'itemable_id' => $estancia->id,
                'itemable_type' => 'App\Models\Estancia',
                'estado' => SolicitudEstudio::ESTADO_SOLICITADO
            ]);

            $itemsCreados = collect();

            // 2. Estudios del Catálogo
            if ($request->filled('estudios_agregados_ids')) {
                foreach ($request->estudios_agregados_ids as $catalogoId) {
                    $estudioDb = CatalogoEstudio::find($catalogoId);
                    $instanciaItem = FormularioInstancia::create([
                        'fecha_hora' => now(),
                        'estancia_id' => $estancia->id,
                        'formulario_catalogo_id' => FormularioCatalogo::ID_PAQUETES,
                        'user_id' => Auth::id(),
                    ]);

                    $item = Paquete::create([
                        'id' => $instanciaItem->id,
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => $catalogoId,
                        'departamento_destino' => $estudioDb->departamento ?? 'GENERAL',
                        'estado' => 'SOLICITADO',
                    ]);

                    $itemsCreados->push($item);
                    $this->registrarVentaItem($ventaService, $estancia, $catalogoId);
                }
            }

            // 3. Estudios Manuales
            if ($request->filled('estudios_adicionales')) {
                foreach ($request->estudios_adicionales as $manual) {
                    $instanciaManual = FormularioInstancia::create([
                        'fecha_hora' => now(),
                        'estancia_id' => $estancia->id,
                        'formulario_catalogo_id' => FormularioCatalogo::ID_PAQUETES,
                        'user_id' => Auth::id(),
                    ]);

                    $item = Paquete::create([
                        'id' => $instanciaManual->id,
                        'solicitud_estudio_id' => $solicitud->id,
                        'otro_estudio' => $manual['nombre'],
                        'departamento_destino' => $manual['departamento'] ?? 'GENERAL',
                        'estado' => 'SOLICITADO',
                    ]);
                    $itemsCreados->push($item);
                }
            }

            DB::commit();

            // 4. Notificaciones (Protegidas contra errores de Twilio)
           /* try {
                if ($itemsCreados->isNotEmpty() && config('services.twilio.sid')) {
                    $this->notificarDepartamentos($solicitud, $itemsCreados);
                }
            } catch (\Exception $e) {
                Log::error("Error de notificación (Twilio saltado): " . $e->getMessage());
            }*/

            return Redirect::route('estancias.show', [ $estancia->id])
                ->with('success', 'Solicitud y paquetes creados correctamente.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error en PaqueteController: " . $e->getMessage());
            return Redirect::back()->with('error', 'Error al procesar: ' . $e->getMessage());
        }
    }
private function registrarVentaItem(VentaService $ventaService, Estancia $estancia, $catalogo_estudio_id)
{
    $estudio = CatalogoEstudio::find($catalogo_estudio_id);
    if (!$estudio) return;

    $producto = ProductoServicio::where('nombre_prestacion', $estudio->nombre)->first();

    if (!$producto) {
        Log::warning("No se encontró un producto/servicio para el estudio: " . $estudio->nombre);
        return;
    }

    $ventaExistente = Venta::where('estancia_id', $estancia->id)
        ->where('estado', Venta::ESTADO_PENDIENTE)
        ->first();

    $itemVenta = [
        'id' => $producto->id,
        'cantidad' => 1,
        'tipo' => $producto->tipo,
        'nombre' => $producto->nombre_prestacion,
        'precio' => $producto->importe, 
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
                 $user->notify(new NuevaSolicitudEstudios($itemsGrupo, $paciente, $solicitud->id));
            }
        }
    }
/*
    private function obtenerUsuariosPorDepto($departamento)
    {
        $d = mb_strtoupper($departamento, 'UTF-8');
        return match (true) {
            str_contains($d, 'LABORATORIO') => User::role('técnico de laboratorio')->get(),
            str_contains($d, 'RAYOS') || str_contains($d, 'ULTRA') => User::role('radiólogo')->get(),
            default => User::role('administrador')->get(),
        };
    }*/
}