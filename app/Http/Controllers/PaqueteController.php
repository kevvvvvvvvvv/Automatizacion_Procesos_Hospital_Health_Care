<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use App\Models\Estudio\SolicitudEstudio;
use App\Models\Paquete; 
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
use App\Services\PdfGeneratorService;

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
    public function create(Estancia $estancia)
    {

        //dd($estancia->toArray());
        return Inertia::render('formularios/paquetes/create', [
            'estancia' => $estancia,
            'catalogoEstudios' => CatalogoEstudio::all(),
            'modeloTipo' => 'App\Models\Estancia',
        ]);
    }

    /**
     * Procesa el formulario
     */
    public function store(Request $request, Estancia $estancia, VentaService $ventaService)
    {
        $request->validate([
            'user_solicita_id' => 'required|exists:users,id',
            'estudios_agregados_ids' => 'array',
            'estudios_adicionales' => 'array',
        ]);

        DB::beginTransaction();
        try {
            // 1. Crear Instancia Maestra para la Solicitud (Cabecera)
            $instanciaCabecera = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS,
                'user_id' => Auth::id(),
            ]);

            $solicitud = SolicitudEstudio::create([
                'id' => $instanciaCabecera->id,
                'user_llena_id' => Auth::id(),
                'user_solicita_id' => $request->user_solicita_id,
                'itemable_id' => $estancia->id,
                'itemable_type' => $request->itemable_type ?? 'App\Models\Estancia',
                'estado' => SolicitudEstudio::ESTADO_SOLICITADO
            ]);

            $itemsCreados = collect();

            // 2. Procesar Estudios de Catálogo
            if ($request->filled('estudios_agregados_ids')) {
                foreach ($request->estudios_agregados_ids as $catalogoId) {
                    $estudioDb = CatalogoEstudio::find($catalogoId);

                    // COMO TU MIGRACIÓN DE PAQUETES PIDE UN ID DE FORMULARIO_INSTANCIAS:
                    $instanciaItem = FormularioInstancia::create([
                        'fecha_hora' => now(),
                        'estancia_id' => $estancia->id,
                        'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS, // O el ID correspondiente a un item
                        'user_id' => Auth::id(),
                    ]);

                    $item = Paquete::create([
                        'id' => $instanciaItem->id, // Primary Key vinculada a formulario_instancias
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => $catalogoId,
                        'departamento_destino' => $estudioDb->departamento ?? 'GENERAL',
                        'estado' => 'SOLICITADO',
                    ]);

                    $itemsCreados->push($item);
                    $this->registrarVentaItem($ventaService, $estancia, $catalogoId);
                }
            }

            // 3. Procesar Estudios Manuales ("Otros")
            if ($request->filled('estudios_adicionales')) {
                foreach ($request->estudios_adicionales as $manual) {
                    $instanciaManual = FormularioInstancia::create([
                        'fecha_hora' => now(),
                        'estancia_id' => $estancia->id,
                        'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS,
                        'user_id' => Auth::id(),
                    ]);

                    $item = Paquete::create([
                        'id' => $instanciaManual->id, // Primary Key vinculada a formulario_instancias
                        'solicitud_estudio_id' => $solicitud->id,
                        'otro_estudio' => $manual['nombre'],
                        'departamento_destino' => $manual['departamento'] ?? 'GENERAL',
                        'estado' => 'SOLICITADO',
                    ]);
                    $itemsCreados->push($item);
                }
            }

            // 4. Notificaciones
            if ($itemsCreados->isNotEmpty()) {
                $this->notificarDepartamentos($solicitud, $itemsCreados);
            }

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success', 'Solicitud y paquetes creados.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error en PaqueteController: " . $e->getMessage());
            return Redirect::back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function registrarVentaItem(VentaService $ventaService, Estancia $estancia, $catalogo_estudio_id)
    {
        $producto = ProductoServicio::where('catalogo_estudio_id', $catalogo_estudio_id)->first();
        if (!$producto) return;

        $ventaExistente = Venta::where('estancia_id', $estancia->id)
            ->where('estado', Venta::ESTADO_PENDIENTE)
            ->first();

        $itemVenta = [
            'id' => $producto->id,
            'cantidad' => 1,
            'tipo' => 'servicio',
            'nombre' => $producto->nombre,
            'precio' => $producto->precio_venta,
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
}