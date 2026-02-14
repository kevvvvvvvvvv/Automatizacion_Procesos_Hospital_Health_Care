<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traslado;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Services\PdfGeneratorService;

use App\Http\Requests\TrasladoRequest;
use App\Models\FormularioCatalogo;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TrasladoController extends Controller implements HasMiddleware
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
        $this->pdfGenerator = $pdfGenerator;
    }

    public function index()
    {
        //
    }

    public function create(Paciente $paciente, Estancia $estancia)     
    {
       
        return Inertia::render('formularios/traslado/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(Paciente $paciente, Estancia $estancia, TrasladoRequest $request)
    {
        
        $validatedData = $request->validated();
        DB::beginTransaction();
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_TRASLADO,
            'user_id' => Auth::id(),
        ]);
        $traslado = Traslado::create([
            'id' => $formularioInstancia->id,
            ...$validatedData
        ]);
        //dd($traslado->toArray());
        DB::commit();
        
        return redirect()->route('estancias.show', [
            'estancia' => $estancia->id,
        ])->with('success', 'Traslado creado exitosamente.');
    }


    public function show(Paciente $paciente, Estancia $estancia, Traslado $traslado)
{ 
    $traslado->load([
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user',
    ]);

    // Verificación para evitar null
    if (!$traslado->formularioInstancia || !$traslado->formularioInstancia->estancia || !$traslado->formularioInstancia->estancia->paciente) {
        abort(404, 'Datos del traslado no encontrados.');
    }

    return Inertia::render('formularios/traslado/show', [
        'traslado' => $traslado,
        'paciente' => $traslado->formularioInstancia->estancia->paciente,
        'estancia' => $traslado->formularioInstancia->estancia,
    ]);
}

    public function edit(Traslado $traslado)
    {
        
        $traslado->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user'
        ]);
        //dd($traslado);
        return Inertia::render('formularios/traslado/edit', [
            'traslado' => $traslado,
            'paciente' => $traslado->formularioInstancia->estancia->paciente,
            'estancia' => $traslado->formularioInstancia->estancia,
        ]);
    }
    public function update(TrasladoRequest $request, Traslado $traslado, Paciente $paciente, Estancia $estancia)
    {
        //dd($request);
        $validatedData = $request->validated();
        $traslado->update($validatedData);
        return redirect()->route('traslados.show', [
            'traslado' => $traslado->id
            ])
            ->with('Success', 'Nota de traslado actualizada');
    }

    /*public function destroy($id)
    {
        $traslado->delete();
        return redirect()->route('pacientes.estancias.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
        ])->with('success', 'Traslado eliminado exitosamente.');
    }*/

    public function generarPDF(Traslado $traslado)
    {
        $traslado->load(
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
        );

        $paciente = $traslado->formularioInstancia->estancia->paciente;
        $medico = $traslado->formularioInstancia->user;
        $estancia = $traslado->formularioInstancia->estancia;

        $headerData = [
            'historiaclinica' => $traslado,
            'paciente' => $paciente,
            'estancia' => $estancia, 
        ];

        $viewData = [
            'notaData' => $traslado,
            'paciente' => $paciente,
            'medico' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-traslado',
            $viewData,
            $headerData,
            'nota-traslado',
            $estancia->folio
        );
    }

}
