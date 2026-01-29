<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\NotaEgreso;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\NotaEgresoRequest;
use App\Models\FormularioCatalogo;
use App\Services\PdfGeneratorService;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;


/**
 * Controlador para la gestión de Notas de egreso.
 * Maneja el flujo de CRUD y generación de PDF
 * para las notas de egreso de los pacientes.
 */
class NotasEgresoController extends Controller
{

    /**
     * Servicio para la generación de PDFs.
     * @var PdfGeneratorService
     */
    protected $pdfGenerator;


    /**
     * Inicializa el controlador con sus dependencias.
     * @param PdfGeneratorService $pdfGenerator Servicio inyectado para crear PDFs estandarizados.
     */    
    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function index(){
        //
    }

    /**
     * Muestra el formulario para crear una nueva nota de egreso.
     * @param Paciente $paciente Modelo del paciente.
     * @param Estancia $estancia Modelo de la estancia actual.
     * @return Response Renderizado de Inertia.
     */
    public function create(paciente $paciente, Estancia $estancia){
        return Inertia::render('formularios/notaegreso/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }


    /**
     * Almacena una nueva nota de egreso en la base de datos.
     * Realiza la validación, crea la instancia del formulario y la nota
     * dentro de una transacción de base de datos.
     * @param NotaEgresoRequest $request Objeto con los datos validados.
     * @param Paciente $paciente Modelo del paciente.
     * @param Estancia $estancia Modelo de la estancia.
     * @return RedirectResponse Redirección a la vista de la estancia o atrás en caso de error.
     */
    public function store(NotaEgresoRequest $request ,paciente $paciente, Estancia $estancia){
        $validateData = $request->validated();

        if ($validateData['motivo_egreso'] === 'otro') {
            $validateData['motivo_egreso'] = $validateData['motivo_egreso_otro'];
        }
        unset($validateData['motivo_egreso_otro']);

        DB::beginTransaction();
        try{
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_EGRESO, 
                'user_id' => Auth::id(),
            ]);
            $notaEgreso = NotaEgreso::create([
                'id' => $formularioInstancia->id,
                ...$validateData
            ]);
            DB::commit();
                    
            return redirect()->route('estancias.show', [
                'estancia' => $estancia->id,
            ])->with('success', 'Nota de egreso creada exitosamente.');
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear la nota de egreso: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al crear nota de egreso.'); 
        }
    }


    /**
     * Muestra una nota de egreso específica.
     * @param NotaEgreso $notasegreso La nota a visualizar.
     * @param Paciente $paciente El paciente asociado.
     * @param Estancia $estancia La estancia asociada.
     * @return Response Renderizado de Inertia.
     */
    public function show(NotaEgreso $notasegreso, paciente $paciente, Estancia $estancia)
    {
        $notasegreso->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');

        $paciente = $notasegreso->formularioInstancia->estancia->paciente;  
        $estancia = $notasegreso->formularioInstancia->estancia;
        
        return Inertia::render('formularios/notaegreso/show', [
            'notaEgreso' => $notasegreso,
            'paciente'   => $paciente,
            'estancia'   => $estancia,
        ]);
    }

    public function update(paciente $paciente, Estancia $estancia, NotaEgresoRequest $request, NotaEgreso $notasegreso){
        $validateData = $request->validated();
        $notasegreso->update($validateData);

        return redirect()->route('notasegresos.show', [
            'notasegreso' => $notasegreso->id,
        ])->with('success', 'Nota de egreso actualizada'); 
    }

    public function edit( NotaEgreso $notasegreso){
       
        $notasegreso->load('formularioInstancia.estancia.paciente',
        'formularioInstancia.user'
        
    );
     //dd($notasegreso->toArray());
    return Inertia::render('formularios/notaegreso/edit', [
        'egreso' => $notasegreso,
        'paciente' => $notasegreso->formularioInstancia->estancia->paciente,
        'estancia' => $notasegreso->formularioInstancia->estancia,
    ]);
    }


    /**
     * Genera y descarga el PDF de la nota de egreso.
     * @param NotaEgreso $notasegreso La nota de la cual generar el PDF.
     * @return mixed Retorna la descarga o stream del PDF.
     */
    public function generarPDF(NotaEgreso $notasegreso) 
    {
        $notasegreso->load(
            'formularioInstancia.estancia.paciente', 
            'formularioInstancia.user.credenciales'
        );
        
        $medico = $notasegreso->formularioInstancia->user;
        $estancia = $notasegreso->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        $headerData = [
            'historiaclinica' => $notasegreso,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ];

        $viewData = [
            'notaData' => $notasegreso,
            'pacientte' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-egreso',
            $viewData,
            $headerData,
            'nota-egreso-',
            $estancia->folio,
        );

    }
}