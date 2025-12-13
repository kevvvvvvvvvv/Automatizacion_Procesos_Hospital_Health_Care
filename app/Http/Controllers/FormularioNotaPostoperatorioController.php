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

class FormularioNotaPostoperatorioController extends Controller
{
    protected $pdfGenerator;

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

        $camposPatologia = [
            'estudio_solicitado', 'biopsia_pieza_quirurgica', 'revision_laminillas',
            'estudios_especiales', 'pcr', 'pieza_remitida', 'datos_clinicos', 'empresa_enviar'
        ];

        DB::beginTransaction();
        try{

            $solicitudPatologiaId = null;
            $datosPatologia = Arr::only($validatedData, $camposPatologia);
            
            if (!empty(array_filter($datosPatologia))) {
                
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

                $idPatologia = ProductoServicio::select('id')
                                                ->where('codigo_prestacion','85121801_01');

                $itemParaVenta = [
                    'id' => $idPatologia,
                    'cantidad' => 1,
                    'tipo' => 'producto'
                ]; 

                $solicitudPatologiaId = $solicitud->id;

                $ventaExistente = Venta::where('estancia_id', $estancia->id)
                                        ->where('estado', Venta::ESTADO_PENDIENTE)
                                        ->first();
                
                if ($ventaExistente) {
                    $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
                } else {
                    $ventaService->crearVenta([$itemParaVenta], $estancia->id, Auth::id());
                }                                        
            }

            $formNota = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_POSTOPERATOIRA, 
                'user_id' => Auth::id(),
            ]);

            $datosNota = Arr::except($validatedData, array_merge(
                $camposPatologia, 
                ['ayudantes_agregados', 'transfusiones_agregadas']
            ));

            $nota = NotaPostoperatoria::create([
                'id' => $formNota->id,
                'user_id' => Auth::id(),
                'solicitud_patologia_id' => $solicitudPatologiaId,
                ...$datosNota
            ]);

            if (!empty($validatedData['ayudantes_agregados'])) {
                $ayudantes = array_map(function ($item) {
                    return [
                        'user_id' => $item['ayudante_id'],
                        'cargo' => $item['cargo'],
                    ];
                }, $validatedData['ayudantes_agregados']);
                
                $nota->personalEmpleados()->createMany($ayudantes);
            }

            if (!empty($validatedData['transfusiones_agregadas'])) {
                $nota->transfusiones()->createMany($validatedData['transfusiones_agregadas']);
            }

            DB::commit();
            
            return Redirect::route('estancias.show', $estancia->id)
                ->with('success', 'Se ha creado la nota postoperatoria exitosamente.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear nota postoperatoria: ' . $e->getMessage());
            return Redirect::back()->with('error','No se pudo crear la nota postoperatoria.');
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
