<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudPatologiaRequest;
use DB;
use Exception;
use Redirect;
use Auth;
use Log;
use App\Services\PdfGeneratorService;

use App\Models\Estancia;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Estudio\SolicitudPatologia;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SolicitudEstudioPatologiaController extends Controller implements HasMiddleware
{

    protected $pdfGenerator;
    use AuthorizesRequests;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar solicitudes estudios patologicos', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear solicitudes estudios patologicos', only: ['create','store']),
            new Middleware($permission . ':editar solicitudes estudios patologicos', only: ['edit', 'update']),
            new Middleware($permission . ':eliminar solicitudes estudios patologicos', only: ['destroy']),
        ];
    }

    public function __construct(PdfGeneratorService $pdfGenerator){
        return $this->pdfGenerator = $pdfGenerator;
    }

    public function store(SolicitudPatologiaRequest $request, Estancia $estancia)
    {
        DB::beginTransaction();
        try{
            $validatedData = $request->validated();

            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_PATOLOGIA,
                'user_id' =>  Auth::id(),
            ]);

            SolicitudPatologia::create([
                ...$validatedData,
                'id' => $formularioInstancia->id,
                'fecha_estudio' => now(),
            ]);

            DB::commit();
            return Redirect::back()->with('success','Se ha creado la solicitud de estudio anatomopatológico');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear la solicitud de estudio anatomopatológico' . $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitud de estudio anatomopatológico.');    
        }
    }

    public function generarPDF(SolicitudPatologia $solicitudespatologia)
    {
        
        $solicitudespatologia->load(
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user.credenciales',
        );

        $paciente = $solicitudespatologia->formularioInstancia->estancia->paciente;
        $medico = $solicitudespatologia->formularioInstancia->user;
        $estancia = $solicitudespatologia->formularioInstancia->estancia;

        $headerData = [
            'historiaclinica' => $solicitudespatologia,
            'estancia' => $estancia,
            'paciente' => $paciente,
        ];

        $viewData = [
            'notaData' => $solicitudespatologia,
            'paciente' => $paciente,
            'meidco' => $medico,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.solicitud-patologia',
            $viewData,
            $headerData,
            'solicitud-patologia-',
            $estancia->id
        );
        
    }
}
