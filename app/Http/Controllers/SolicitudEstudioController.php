<?php

namespace App\Http\Controllers;

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

class SolicitudEstudioController extends Controller
{
    public function store(Request $request)
    {

        dd($request->toArray());
        $validated = $request->validate([
            'diagnostico_problemas' => 'nullable|string',
            'incidentes_accidentes' => 'nullable|string',
           
            'estudios_agregados_ids' => 'array', 
            'estudios_adicionales' => 'array',
            
            'estudios_agregados_ids.*' => 'integer|exists:catalogo_estudios,id',
            'estudios_adicionales.*' => 'string|max:255',
        ]);

        DB::transaction();
        try{
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),  
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_NOTA_EGRESO, 
                'user_id' => Auth::id(),
            ]);
            
            
            $solicitud = new SolicitudEstudio();

            $solicitud->id = $formularioInstancia->id;
            $solicitud->user_llena_id = Auth::id();
            $solicitud->user_solicita_id = $request->user_solicita_id;

            $solicitud->save();

            if (!empty($request->estudios_agregados_ids)) {
                foreach ($request->estudios_agregados_ids as $catalogoId) {
                    SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => $catalogoId,
                        'detalles' => $detallesJson,
                        'otro_estudio' => null, 
                        'estado' => 'solicitado'
                    ]);
                }
            }

            if (!empty($request->estudios_adicionales)) {
                foreach ($request->estudios_adicionales as $nombreEstudioManual) {
                    SolicitudItem::create([
                        'solicitud_estudio_id' => $solicitud->id,
                        'catalogo_estudio_id' => null, 
                        'detalles' => $detallesJson,
                        'otro_estudio' => $nombreEstudioManual, 
                        'estado' => 'solicitado'
                    ]);
                }
            }


            DB::commit();
            return Redirect::back()->with('success','Se ha creado la solicitud de estudios');
        }catch(\Exception $e){
            DB::rollback();
            Log::error('Error al crear la solicitud de estudios: '. $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitud de estudios');
        }
    }
}
