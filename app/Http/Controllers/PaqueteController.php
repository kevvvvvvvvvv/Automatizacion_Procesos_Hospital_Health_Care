<?php

namespace App\Http\Controllers;

use App\Models\Estancia;
use App\Models\Estudio\SolicitudEstudio;
use App\Models\Estudio\SolicitudItem;
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Inventario\ProductoServicio;
use App\Models\Venta\Venta;
use App\Models\User;
use App\Services\PdfGeneratorService;
use App\Services\VentaService;
use App\Services\TwilioWhatsAppService;
use App\Notifications\NuevaSolicitudEstudios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PaqueteController extends Controller
{
    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * Muestra la vista de selección de paquetes/estudios
     */
    public function create(Estancia $estancia)
    {
        return Inertia::render('formularios/paquetes/create', [
            'estancia' => $estancia,
            'catalogoEstudios' => CatalogoEstudio::all(),
            'medicos' => User::role('medico')->get(), // Asumiendo que tienes este rol
            'modeloTipo' => 'App\Models\Estancia',
        ]);
    }

    /**
     * Procesa el formulario de los checkboxes
     */
    public function store(Request $request, Estancia $estancia, VentaService $ventaService, TwilioWhatsAppService $twilio)
    {
        // 1. Validación básica
        $request->validate([
            'user_solicita_id' => 'required|exists:users,id',
            'estudios_agregados_ids' => 'array',
            'estudios_adicionales' => 'array',
        ]);

        DB::beginTransaction();
        try {
            // 2. Crear Cabecera (Reutilizando lógica de SolicitudEstudioController)
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS,
                'user_id' => Auth::id(),
            ]);

            $solicitud = SolicitudEstudio::create([
                'id' => $formularioInstancia->id,
                'user_llena_id' => Auth::id(),
                'user_solicita_id' => $request->user_solicita_id,
                'itemable_id' => $estancia->id,
                'itemable_type' => $request->itemable_type ?? 'App\Models\Estancia',
                'estado' => 'SOLICITADO'
            ]);

            $itemsCreados = collect();

            // 3. Guardar Estudios del Catálogo (IDs)
            if ($request->has('estudios_agregados_ids')) {
                foreach ($request->estudios_agregados_ids as $catalogoId) {
                    $item = SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => $catalogoId,
                        'estado' => 'SOLICITADO',
                    ]);
                    $itemsCreados->push($item);

                    // Procesar la venta automáticamente
                    $this->registrarVentaItem($ventaService, $estancia->id, $catalogoId);
                }
            }

            // 4. Guardar Estudios Manuales (Los que no estaban en el catálogo)
            if ($request->has('estudios_adicionales')) {
                foreach ($request->estudios_adicionales as $manual) {
                    $item = SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'otro_estudio' => $manual['nombre'],
                        'detalles' => ['departamento_manual' => $manual['departamento'] ?? 'GENERAL'],
                        'estado' => 'SOLICITADO',
                    ]);
                    $itemsCreados->push($item);
                }
            }

            // 5. Notificaciones (Lógica simplificada del otro controller)
            $this->notificarDepartamentos($solicitud, $itemsCreados);

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success', 'Paquetes y servicios solicitados correctamente.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error en PaqueteController@store: " . $e->getMessage());
            return Redirect::back()->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Lógica para registrar el cobro en la venta actual de la estancia
     */
    private function registrarVentaItem(VentaService $ventaService, $estancia_id, $catalogo_estudio_id)
    {
        $estudio = ProductoServicio::find($catalogo_estudio_id);
        if (!$estudio) return;

        $ventaExistente = Venta::where('estancia_id', $estancia_id)
            ->where('estado', Venta::ESTADO_PENDIENTE)
            ->first();

        $itemVenta = [
            'id' => $estudio->id,
            'cantidad' => 1,
            'tipo' => 'producto',
            'nombre' => $estudio->nombre,
        ];

        if ($ventaExistente) {
            $ventaService->addItemToVenta($ventaExistente, $itemVenta);
        } else {
            $ventaService->crearVenta([$itemVenta], $estancia_id, Auth::id());
        }
    }

    /**
     * Envía las notificaciones pertinentes a laboratorio, rayos x, etc.
     */
    private function notificarDepartamentos($solicitud, $items)
    {
        $paciente = $solicitud->formularioInstancia->estancia->paciente;
        
        $grupos = $items->groupBy(function ($item) {
            return $item->catalogoEstudio->departamento ?? $item->detalles['departamento_manual'] ?? 'GENERAL';
        });

        foreach ($grupos as $depto => $itemsGrupo) {
            $usuarios = $this->obtenerUsuariosPorDepto($depto);
            foreach ($usuarios as $user) {
                $user->notify(new NuevaSolicitudEstudios($itemsGrupo, $paciente, $solicitud->id));
            }
        }
    }

    private function obtenerUsuariosPorDepto($departamento)
    {
        $d = mb_strtoupper($departamento, 'UTF-8');
        return match (true) {
            in_array($d, ['HEMATOLOGÍA', 'QUÍMICA CLÍNICA', 'LABORATORIO']) => User::role('técnico de laboratorio')->get(),
            in_array($d, ['RADIOLOGÍA GENERAL', 'ULTRASONIDO', 'RAYOS X']) => User::role('radiólogo')->get(),
            default => User::role('administrador')->get(),
        };
    }
}