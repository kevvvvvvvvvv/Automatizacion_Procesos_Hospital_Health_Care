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
        //dd($request->toArray());
        $validateData = $request->validated();
       //dd($request->toArray());
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

            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota de evolución');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear nota de evolución: ' . $e->getMessage());
        }
    }

      public function show(Paciente $paciente, Estancia $estancia, NotaEvolucion $notasevolucione)
    {
        $notasevolucione->load([
            'formularioInstancia.estancia.paciente',
             'formularioInstancia.user']);
        
        return Inertia::render('formularios/notaevolucion/show', [
            'notasevolucione' => $notasevolucione,  
            'paciente' => $notasevolucione->formularioInstancia->estancia->paciente,
            'estancia' => $notasevolucione->estancia,
        ]);
    }
    public function edit (){
        //
    }
    public function update(NotaEvolucionRequest $request, Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $validateData = $request->validated();
        $notaEvolucion->update($validateData);
        return redirect()->route('pacientes.estancias.notasevoluciones.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'notaevolucion' => $notaEvolucion->id, 
        ])->with('success', 'Nota de Evolución actualizada exitosamente.');
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
