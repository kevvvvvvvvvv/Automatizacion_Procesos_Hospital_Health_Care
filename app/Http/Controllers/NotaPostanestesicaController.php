<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaPostanestesicaRequest;
use App\Models\Estancia;
use App\Models\Paciente;
use App\Models\FormularioInstancia;
use App\Models\FormularioCatalogo;
use App\Models\NotaPostanestesica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Inertia\Inertia;


class NotaPostanestesicaController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

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
        $this->pdfGenerator = $pdfGenerator;
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/nota-postanestesica/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(NotaPostanestesicaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_POSTANESTESICA,
                'user_id' => Auth::id(),
            ]);

            NotaPostanestesica::create([
                'id' => $formulario->id,
                ...$validatedData
            ]);

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota postanestesica.');
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Error al crear hoja frontal: ' . $e->getMessage());
            return Redirect::back()->with('error','No se pudo crear la nota postanestésica: ' . $e->getMessage());
        }
    }
    public function edit(NotaPostanestesica $notaspostanestesica){
        $notaspostanestesica->load('formularioInstancia.user', 'formularioInstancia.estancia.paciente');
        $estancia = $notaspostanestesica->formularioInstancia->estancia;
        $paciente = $estancia->paciente;
        //dd($notaspostanestesica->toArray());
        return Inertia::render ('formularios/nota-postanestesica/edit', [
                'paciente' => $paciente,
                'estancia' => $estancia,
                'nota' => $notaspostanestesica,
        ]);

    }
    // Cambia el nombre de la variable de $notaspostanestesica a $notaspreanestesica
        public function update(NotaPostanestesica $notaspostanestesica, NotaPostanestesicaRequest $request) 
        {
            $validatedData = $request->validated();
            $notaspostanestesica->update($validatedData);
                    $estancia = $notaspostanestesica->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

            
         return Inertia::render('formularios/nota-postanestesica/show', [
        'paciente' => $paciente,
        'estancia' => $estancia,
        'nota' => $notaspostanestesica
    ]);
}
    public function show(NotaPostanestesica $notaspostanestesica)
{
        $notaspostanestesica->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');
        $estancia = $notaspostanestesica->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

    return Inertia::render('formularios/nota-postanestesica/show', [
        'paciente' => $paciente,
        'estancia' => $estancia,
        'nota' => $notaspostanestesica
    ])->with('success','Se ha creado la nota postanestesica.');
}

    public function generarPDF(NotaPostanestesica $notaspostanestesica)
    {
        $notaspostanestesica->load(
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
        );

        $paciente = $notaspostanestesica->formularioInstancia->estancia->paciente;
        $medico = $notaspostanestesica->formularioInstancia->user;
        $estancia = $notaspostanestesica->formularioInstancia->estancia;

        $headerData = [
            'historiaclinica' => $notaspostanestesica,
            'paciente' => $paciente,
            'estancia' => $estancia, 
        ];

        $viewData = [
            'notaData' => $notaspostanestesica,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-postanestesica',
            $viewData,
            $headerData,
            'nota-postanestesica-',
            $estancia->folio
        );
    }
}
