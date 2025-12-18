<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudEstudioRequest;
use Illuminate\Http\Request;

use App\Models\Estancia;
use App\Models\FormularioInstancia; 
use App\Models\SolicitudEstudio;
use App\Models\SolicitudItem;
use Illuminate\Support\Facades\Auth;
use App\Models\FormularioCatalogo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class SolicitudEstudioController extends Controller
{
    public function store(SolicitudEstudioRequest $request, Estancia $estancia)
    {

        $validatedData = $request->validated();
        $detallesArray = $request->input('detallesEstudios', []);

        dd($validatedData);

        DB::beginTransaction();
        try{
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_SOLICITUD_ESTUDIOS, 
                'user_id' => Auth::id(),
            ]);
            
            $solicitud = new SolicitudEstudio();
            $solicitud->id = $formularioInstancia->id;
            $solicitud->user_llena_id = Auth::id();
            $solicitud->user_solicita_id = $request->user_solicita_id;
            $solicitud->save();

  
            if (!empty($request->estudios_agregados_ids)) {
                foreach ($request->estudios_agregados_ids as $index => $catalogoId) {
                    $detalleItem = $detallesArray[$catalogoId] ?? null; 

                    SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => $catalogoId,
                        'detalles' => $detalleItem,
                        'otro_estudio' => null, 
                        'estado' => 'solicitado'
                    ]);
                }
            }

            if (!empty($request->estudios_adicionales)) {
                foreach ($request->estudios_adicionales as $index => $nombreEstudioManual) {
                    $detalleItem = isset($detallesArray['adicional_' . $index]) 
                                    ? $detallesArray['adicional_' . $index] 
                                    : null; 

                    SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => null, 
                        'detalles' => $detalleItem, 
                        'otro_estudio' => $nombreEstudioManual, 
                        'estado' => 'solicitado'
                    ]);
                }
            }

            DB::commit();
            return Redirect::back()->with('success','Se ha creado la solicitud de estudios');

        } catch(\Exception $e){
            DB::rollback();
            Log::error('Error al crear la solicitud de estudios: '. $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitud de estudios');
        }
    }

    public function generarPDF(SolicitudEstudio $solicitudes_estudio)
    {
        $solicitudes_estudio->load(
            'userSolicita',
            'userLlena',
            'solicitudItems.catalogoEstudio',
            'formularioInstancia.estancia.paciente'
        ); 

        //dd($solicitudes_estudio->toArray());
        return Pdf::view('pdfs.solicitud-estudio',['solicitud' => $solicitudes_estudio])
            ->withBrowsershot(function (Browsershot $browsershot){
                $chromePath = config('services.browsershot.chrome_path');
                if ($chromePath) {
                    $browsershot->setChromePath($chromePath);
                    $browsershot->noSandbox();
                    $browsershot->addChromiumArguments([
                        'disable-dev-shm-usage',
                        'disable-gpu',
                    ]);
                }
            })
            ->inline('solicitud examen.pdf');
            
    }
}
