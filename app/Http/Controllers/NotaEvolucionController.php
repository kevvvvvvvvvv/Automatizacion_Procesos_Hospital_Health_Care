<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotaEvolucion;   
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\NotaEvolucionRequest;
use App\Models\FormularioCatalogo;
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
        return Inertia::render('formularios/notaevolucion/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
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

            return redirect()->route('estancias.show', [
                'estancia' => $estancia->id,
            ])->with('success', 'Nota de Evolución creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear nota de evolución: ' . $e->getMessage());
        }
    }

    public function show(Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $notaEvolucion->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');

        return Inertia::render('formularios/notaevolucion/show', [
            'notaEvolucion' => $notaEvolucion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function edit(Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $notaEvolucion->load('formularioInstancia');

        return Inertia::render('formularios/notaevolucion/edit', [
            'notaEvolucion' => $notaEvolucion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function update(NotaEvolucionRequest $request, Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $validateData = $request->validated();

        $notaEvolucion->update($validateData);

        return redirect()->route('pacientes.estancias.notasevoluciones.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'notaEvolucion' => $notaEvolucion->id,
        ])->with('success', 'Nota de Evolución actualizada exitosamente.');
    }

    public function generarPDF(NotaEvolucion $notasevolucion)
    {
        $notasevolucion->load(
            'formularioInstancia.estancia.paciente', 
            'formularioInstancia.user.credenciales',
        );

        $medico = $notasevolucion->formularioInstancia->user;
        $estancia = $notasevolucion->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        $headerData = [
            'historiaclinica' =>$notasevolucion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ];

        $viewData = [
            'evolucion' => $notasevolucion,
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