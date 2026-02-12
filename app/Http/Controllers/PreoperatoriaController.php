<?php

namespace App\Http\Controllers;

use App\Services\PdfGeneratorService;
use Illuminate\Http\Request;
use App\Models\Preoperatoria;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\PreoperatoriaRequest;
use App\Models\FormularioCatalogo;
use Spatie\Browsershot\Browsershot;
use Redirect;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PreoperatoriaController extends Controller implements HasMiddleware
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
    public function create(paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/preoperatoria/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(PreoperatoriaRequest $request, Paciente $paciente, Estancia $estancia)
    {   //dd($request->toArray());
        $validatedData = $request->validated();
        //dd($validatedData);
        DB::beginTransaction();
        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_PREOPERATORIA, 
                'user_id' => Auth::id(),
            ]);
            $preoperatoria = Preoperatoria::create([
                'id' => $formularioInstancia->id,
                ...$validatedData
            ]);
            DB::commit();
            return redirect()->route('estancias.show', [
                'estancia' => $estancia->id,
            ])->with('success', 'Preoperatoria creada exitosamente.');
    } catch (\Exception $e) {
        DB::rollBack(); 
        return redirect()->back()->withErrors(['error' => 'Error al crear la preoperatoria: ' . $e->getMessage()])->withInput();
    }
    }
    public function show(Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        ]);
        return Inertia::render('formularios/preoperatoria/show', [
            'preoperatoria' => $preoperatoria,  
            'paciente'      => $preoperatoria->formularioInstancia->estancia->paciente,
            'estancia'      => $preoperatoria->formularioInstancia->estancia,
        ]);

    }
    public function edit(Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
    {   
        //dd($estancia->toArray());
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
        ]);
        return Inertia::render('formularios/preoperatoria/edit', [
            'paciente' => $preoperatoria->formularioInstancia->estancia->paciente,
            'estancia' => $preoperatoria->formularioInstancia->estancia,
            'preoperatoria' => $preoperatoria,
        ]);
    }
   public function update(PreoperatoriaRequest $request, Paciente $paciente, Estancia $estancia, Preoperatoria $preoperatoria)
{

    $validatedData = $request->validated();
    $preoperatoria->update($validatedData);
    
    // Forzamos la llave del parámetro para que Laravel no se pierda
     return redirect()->route('preoperatorias.show', [
                'paciente' => $paciente->id,
                'estancia' => $estancia->id,
                'preoperatoria' => $preoperatoria->id, 
            ])->with('success', 'Nota preoperatoria actualizada.');
}
    public function destroy($id)
    {
        //
    }

    public function generarPDF(Preoperatoria $preoperatoria)
    {
        $preoperatoria->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user.credenciales',
        ]);
        
        $medico = $preoperatoria->formularioInstancia->user;
        $estancia = $preoperatoria->formularioInstancia->estancia;
        $paciente = $estancia->paciente;

        $headerData = [
            'historiaclinica' => $preoperatoria, 
            'paciente' => $paciente,
            'estancia' => $estancia
        ];

        $viewData = [
            'notaData' => $preoperatoria,
            'paciente' => $paciente,
            'medico' => $medico,
        ];
        
        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.nota-preoperatoria',
            $viewData,
            $headerData,
            'nota-preoperatoria-',
            $estancia->folio
        );
         
    }
}
