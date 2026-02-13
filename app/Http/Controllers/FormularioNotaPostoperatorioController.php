<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaPostoperatoriaRequest;
use App\Models\CatalogoEstudio;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Models\NotaPostoperatoria;
use App\Models\PersonalEmpleado;
use App\Models\ProductoServicio;
use App\Models\SolicitudPatologia;
use App\Models\TransfusionRealizada;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;
use App\Services\VentaService; 

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class FormularioNotaPostoperatorioController extends Controller implements HasMiddleware
{
    protected $pdfGenerator;
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar hojas', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear hojas', only: ['create', 'store']),
            new Middleware($permission . ':eliminar hojas', only: ['destroy']),
        ];
    }

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        return $this->pdfGenerator = $pdfGenerator;
    }

    public function show()
    {

    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $personal = User::all();
        $soluciones = ProductoServicio::where('tipo','INSUMOS')->get();
        $medicamentos = ProductoServicio::where('tipo','INSUMOS')->get();
        $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();

        return Inertia::render('formularios/nota-postoperatorio/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'users' => $personal,
            'soluciones' => $soluciones,
            'medicamentos' => $medicamentos,
            'estudios' => $estudios,
        ]);
    }

    public function store(NotaPostoperatoriaRequest $request, Paciente $paciente, Estancia $estancia, VentaService $ventaService)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $solicitudPatologia = $this->procesarSolicitudPatologia($validatedData, $estancia, $ventaService);
            $nota = $this->crearNotaPostoperatoria($validatedData, $estancia, $solicitudPatologia?->id);
            if ($solicitudPatologia) {
                $this->vincularPatologiaNota($solicitudPatologia, $nota);
            }
            $this->guardarRelaciones($nota, $validatedData);

            DB::commit();

            return Redirect::route('estancias.show', $estancia->id)
                ->with('success', 'Se ha creado la nota postoperatoria exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear nota postoperatoria: ' . $e->getMessage());
            return Redirect::back()->with('error', 'No se pudo crear la nota postoperatoria.');
        }
    }

    private function procesarSolicitudPatologia(array $data, Estancia $estancia, VentaService $ventaService): ?SolicitudPatologia
    {
        $camposPatologia = [
            'estudio_solicitado', 'biopsia_pieza_quirurgica', 'revision_laminillas',
            'estudios_especiales', 'pcr', 'pieza_remitida', 'datos_clinicos', 'empresa_enviar'
        ];

        $datosPatologia = Arr::only($data, $camposPatologia);

        if (empty(array_filter($datosPatologia))) {
            return null;
        }

        $formPatologia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_PATOLOGIA,
            'user_id' => Auth::id(),
        ]);

        $solicitud = SolicitudPatologia::create([
            'id' => $formPatologia->id,
            'user_solicita_id' => Auth::id(),
            'fecha_estudio' => now(),
            ...$datosPatologia
        ]);

        //$this->procesarCobroPatologia($estancia, $ventaService);

        return $solicitud;
    }

    private function procesarCobroPatologia(Estancia $estancia, VentaService $ventaService): void
    {
        $idPatologia = ProductoServicio::where('codigo_prestacion', '85121801_01')->value('id');

        if (!$idPatologia) return;

        $itemParaVenta = [
            'id' => $idPatologia,
            'cantidad' => 1,
            'tipo' => 'producto'
        ];

        $ventaExistente = Venta::where('estancia_id', $estancia->id)
                                ->where('estado', Venta::ESTADO_PENDIENTE)
                                ->first();

        if ($ventaExistente) {
            $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
        } else {
            $ventaService->crearVenta([$itemParaVenta], $estancia->id, Auth::id());
        }
    }

    private function crearNotaPostoperatoria(array $data, Estancia $estancia, ?int $solicitudPatologiaId): NotaPostoperatoria
    {
        $formNota = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_POSTOPERATOIRA,
            'user_id' => Auth::id(),
        ]);

        $camposExcluidos = [
            'estudio_solicitado', 'biopsia_pieza_quirurgica', 'revision_laminillas',
            'estudios_especiales', 'pcr', 'pieza_remitida', 'datos_clinicos', 'empresa_enviar',
            'ayudantes_agregados', 'transfusiones_agregadas'
        ];
        
        $datosNota = Arr::except($data, $camposExcluidos);

        return NotaPostoperatoria::create([
            'id' => $formNota->id,
            'user_id' => Auth::id(),
            'solicitud_patologia_id' => $solicitudPatologiaId,
            ...$datosNota
        ]);
    }

    private function vincularPatologiaNota(SolicitudPatologia $solicitud, NotaPostoperatoria $nota): void
{
    $solicitud->update([
        'itemable_id'   => $nota->id,
        'itemable_type' => $nota->getMorphClass(),
    ]);
}

    private function guardarRelaciones(NotaPostoperatoria $nota, array $data): void
    {
        if (!empty($data['ayudantes_agregados'])) {
            $ayudantes = array_map(function ($item) {
                return [
                    'user_id' => $item['ayudante_id'],
                    'cargo' => $item['cargo'],
                ];
            }, $data['ayudantes_agregados']);

            $nota->personalEmpleados()->createMany($ayudantes);
        }

        if (!empty($data['transfusiones_agregadas'])) {
            $nota->transfusiones()->createMany($data['transfusiones_agregadas']);
        }
    }

    public function edit()
    {

    }

    public function generarPDF(NotaPostoperatoria $notaspostoperatoria)
    {
        $notaspostoperatoria->load(
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
            'personalEmpleados.user',
            'transfusiones'
        );

        $paciente = $notaspostoperatoria->formularioInstancia->estancia->paciente;
        $medico = $notaspostoperatoria->formularioInstancia->user;
        $estancia = $notaspostoperatoria->formularioInstancia->estancia;

        $headerData = [
            'historiaclinica' => $notaspostoperatoria,
            'estancia' => $estancia,
            'paciente' => $paciente
        ];

        $viewData = [
            'notaData' => $notaspostoperatoria,
            'paciente' => $paciente,
            'medico'   => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-postoperatoria',
            $viewData,
            $headerData,
            'nota-postoperatoria-',
            $estancia->folio,
        );
    }
}
