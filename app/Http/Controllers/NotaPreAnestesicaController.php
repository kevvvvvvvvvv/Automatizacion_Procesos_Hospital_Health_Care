<?php

namespace App\Http\Controllers;

use App\Models\NotaPreAnestesica;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;              
use Spatie\LaravelPdf\Facades\Pdf;              
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Redirect;
use App\Http\Requests\NotaPreanestesicaRequest;
use App\Services\PdfGeneratorService;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NotaPreAnestesicaController extends Controller implements HasMiddleware
{

    /**
     * Servicio para la generación de PDFs.
     * @var PdfGeneratorService
     */
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

    /**
     * Inicializa el controlador con sus dependencias.
     * @param PdfGeneratorService $pdfGenerator Servicio inyectado para crear PDFs estandarizados.
     */    
    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/notapreanestesica/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(NotaPreanestesicaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validated = $request->validated();
            

        DB::beginTransaction();

        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_PREANESTESICA,
                'user_id' => Auth::id(),
            ]);

            NotaPreAnestesica::create([
                'id' => $formularioInstancia->id,
                ...$validated,
            ]);

            DB::commit();

            return redirect()
                ->route('estancias.show', ['estancia' => $estancia->id])
                ->with('success', 'Nota preanestésica creada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Error al crear la nota preanestésica: ' . $e->getMessage());
        }
    }

    public function show( NotaPreAnestesica $notaspreanestesica)
    {
        $notaspreanestesica->load(
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        );
//dd($notaspreanestesica->toArray());
        return Inertia::render('formularios/notapreanestesica/show', [
            'notaPreanestesica' => $notaspreanestesica,
            'paciente' => $notaspreanestesica->formularioInstancia->estancia->paciente,
            'estancia' => $notaspreanestesica->formularioInstancia->estancia,
        ]);
    }
    public function edit(NotaPreanestesica $notaspreanestesica){
        $notaspreanestesica->load('formularioInstancia.user', 'formularioInstancia.estancia.paciente');
        $estancia = $notaspreanestesica->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        return Inertia::render('formularios/notapreanestesica/edit', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'preanestesica' => $notaspreanestesica,
        ]);
    
    }
    public function update(NotaPreanestesica $notaspreanestesica, NotaPreanestesicaRequest $request){
        $validatedData = $request->validated();
       try {
    $notaspreanestesica->update($validatedData);
    DB::commit();

    // El parámetro debe llamarse 'notaspreanestesica' para coincidir con el URI
    return Redirect::route('notaspreanestesicas.show', [
        'notaspreanestesica' => $notaspreanestesica->id, 
    ])->with('success', 'Nota preanestésica actualizada correctamente');

} catch (\Exception $e) {
            DB::rollBack();
        return redirect()->route('notaspreanestesicas.show', ['preanestesica' => $notaspreanestesica->id])
            ->with('success', 'nota preanestesica actualizada exitosamente.');        }
    
        }
    public function generarPDF(NotaPreAnestesica $notaspreanestesica)
    {
        $notaspreanestesica->load(
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user.credenciales',
        );

        $medico = $notaspreanestesica->formularioInstancia->user;
        $estancia = $notaspreanestesica->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        $headerData = [
            'historiaclinica' => $notaspreanestesica,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ];

        $viewData = [
            'notaData' => $notaspreanestesica,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-preanestesica',
            $viewData,
            $headerData,    
            'nota-preanestesica-',
            $estancia->folio,
        );

    }
}
