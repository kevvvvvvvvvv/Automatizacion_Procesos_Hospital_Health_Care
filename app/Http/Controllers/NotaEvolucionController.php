<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\NotaEvolucionRequest;  
use App\Services\PdfGeneratorService;
use Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Services\Formularios\HojaMedicamentoService; 
use App\Services\Formularios\HojaSolucionService;

use App\Models\Formulario\NotaEvolucion\NotaEvolucion;  
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Estudio\CatalogoEstudio;
use App\Models\Formulario\HojaEnfermeria\HojaMedicamento;
use App\Models\Inventario\ProductoServicio;

class NotaEvolucionController extends Controller implements HasMiddleware
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

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $soluciones = ProductoServicio::where('nombre_prestacion', 'like', 'SOLUCION%')->get();
        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();


        return Inertia::render('formularios/notaevolucion/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'soluciones' => $soluciones,
            'medicamentos' => $medicamentos,
            'estudios' => $estudios,
        ]);
    }

    public function store(
        NotaEvolucionRequest $request, 
        Paciente $paciente, 
        Estancia $estancia, 
        HojaMedicamentoService $medicamentoService,
        HojaSolucionService $solucionSevice)
    {
        $validateData = $request->validated();


        DB::beginTransaction();
        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_EVOLUCION,  
                'user_id' => Auth::id(),
            ]);

            $notaEvolucion = NotaEvolucion::create([
                'id' => $formularioInstancia->id,
                ...$validateData
            ]);

            $medicamentos = $request->input('medicamentos_agregados', []);
            $soluciones = $request->input('soluciones_agregadas', []);
            
            $medicamentoService->registrarMedicamentos($notaEvolucion, $medicamentos);
            $solucionSevice->registrarSoluciones($notaEvolucion,$soluciones);

            DB::commit();

            return Redirect::route('estancias.show', $estancia->id)
                ->with('success', 'Se ha creado la nota de evolución e indicaciones correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Error en NotaEvolucion: " . $e->getMessage());
            return Redirect::back()->with('error', 'Error al crear nota: ' . $e->getMessage());
        }
    }

      public function show( NotaEvolucion $notasevolucione)
    {
        $notasevolucione->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user'
        ]);
        
        return Inertia::render('formularios/notaevolucion/show', [

            'paciente' => $notasevolucione->formularioInstancia->estancia->paciente, 
            'estancia' => $notasevolucione->formularioinstancia->estancia, 
                    'notasevolucione' => $notasevolucione,
        ]);
    }

    public function edit(NotaEvolucion $notasevolucione)
    {
        $notasevolucione->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
            'medicamentos',
            'soluciones.medicamentos',
        ]);

        $soluciones = ProductoServicio::where('nombre_prestacion', 'like', 'SOLUCION%')->get();
        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->get();
        $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();

        return Inertia::render('formularios/notaevolucion/edit', [

            'evolucion' => $notasevolucione, 
            'paciente' => $notasevolucione->formularioInstancia->estancia->paciente,
            'estancia' => $notasevolucione->formularioInstancia->estancia,
            'soluciones' => $soluciones,
            'medicamentos' => $medicamentos,
            'estudios' => $estudios,
        ]);
    }

    public function update(
        NotaEvolucionRequest $request, 
        Paciente $paciente, 
        Estancia $estancia, 
        NotaEvolucion $notasevolucione,
        HojaMedicamentoService $medicamentoService,
        HojaSolucionService $solucionService)
    {
        

        $validateData = $request->validated();
        $notasevolucione->update($validateData);

        $medicamentosRequest = $request->input('medicamentos_agregados', []);
        $solucionesRequest = $request->input('soluciones_agregadas', []);
        
        $medicamentoService->sincronizarMedicamentos($notasevolucione, $medicamentosRequest);
        $solucionService->sincronizarSoluciones($notasevolucione,$solucionesRequest);        

        return redirect()->route('notasevoluciones.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'notasevolucione' => $notasevolucione->id, 
        ])->with('success', 'Nota de Evolución actualizada.');
    }

    public function generarPDF(NotaEvolucion $notasevolucione)
    {
        $notasevolucione->load(
            'formularioInstancia.estancia.paciente', 
            'formularioInstancia.user.credenciales',
        );

        $medico = $notasevolucione->formularioInstancia->user;
        
        $estancia = $notasevolucione->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        $headerData = [
            'historiaclinica' =>$notasevolucione,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ];

        $viewData = [
            'notaData' => $notasevolucione,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-evolucion',
            $viewData,
            $headerData,
            'nota-evolucion-',
            $estancia->folio,
        );

    }
}
