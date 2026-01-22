<?php

namespace App\Http\Controllers;
use App\Models\CatalogoEstudio;
use Illuminate\Http\Request;
use App\Models\NotaEvolucion;   
use App\Models\Paciente;
use App\Models\Estancia;
USE App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Models\ProductoServicio;
use App\Http\Requests\NotaEvolucionRequest;  

use App\Services\PdfGeneratorService;
use Redirect;
class NotaEvolucionController extends Controller
{

    protected $pdfGenerator;

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        return $this->pdfGenerator = $pdfGenerator;
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $soluciones = ProductoServicio::where('tipo','INSUMOS')->get();
        $medicamentos = ProductoServicio::where('tipo','INSUMOS')->get();
        $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();


        return Inertia::render('formularios/notaevolucion/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'soluciones' => $soluciones,
            'medicamentos' => $medicamentos,
            'estudios' => $estudios,
        ]);
    }

    public function store(NotaEvolucionRequest $request, Paciente $paciente, Estancia $estancia)
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

            DB::commit();

            return Redirect::route('estancias.show', $estancia->id)
            ->with('success','Se ha creado la nota de evolución');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear nota de evolución: ' . $e->getMessage());
        }
    }

      public function show( NotaEvolucion $notasevolucione)
{
    $notasevolucione->load([
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user'
    ]);
    
    return Inertia::render('formularios/notaevolucion/show', [

        'paciente' => $notasevolucione->formularioInstancia->estancia->paciente, // El paciente que llega por parámetro
        'estancia' => $notasevolucione->formularioinstancia->estancia, // ¡Asegúrate de que esta línea exista!
                'notasevolucione' => $notasevolucione,
    ]);
}
    public function edit(NotaEvolucion $notasevolucione)
{
    $notasevolucione->load([
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user'
    ]);

    // Necesitas traer estas listas para que el formulario tenga opciones que mostrar
    $soluciones = ProductoServicio::where('tipo','INSUMOS')->get();
    $medicamentos = ProductoServicio::where('tipo','INSUMOS')->get();
    $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();

    return Inertia::render('formularios/notaevolucion/edit', [
        // Cambiamos 'notasevolucione' por 'evolucion' para que coincida con tu React Props
        'evolucion' => $notasevolucione, 
        'paciente' => $notasevolucione->formularioInstancia->estancia->paciente,
        'estancia' => $notasevolucione->formularioInstancia->estancia,
        'soluciones' => $soluciones,
        'medicamentos' => $medicamentos,
        'estudios' => $estudios,
    ]);
}// NotaEvolucionController.php

        public function update(
            NotaEvolucionRequest $request, 
            Paciente $paciente, 
            Estancia $estancia, 
            NotaEvolucion $notasevolucione // <--- Cambia $notaEvolucion por $notasevolucione si es necesario
        ) {
            $validateData = $request->validated();
            $notasevolucione->update($validateData);
            
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
