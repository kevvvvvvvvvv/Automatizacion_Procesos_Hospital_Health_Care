<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitudPatologiaRequest;
use Illuminate\Http\Request;
use DB;
use Exception;
use Redirect;
use Auth;
use Log;

use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\SolicitudPatologia;

class SolicitudEstudioPatologiaController extends Controller
{
    public function store(SolicitudPatologiaRequest $request, Estancia $estancia)
    {
        //dd($request->toArray());
        DB::beginTransaction();
        try{
            $validatedData = $request->validated();

            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => 10,
                'user_id' =>  Auth::id(),
            ]);

            SolicitudPatologia::create([
                ...$validatedData,
                'id' => $formularioInstancia->id,
                'fecha_solucitud' => now(),
            ]);

            DB::commit();
            return Redirect::back()->with('success','Se ha creado la solicitud de estudio anatomopatológico');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear la solicitud de estudio anatomopatológico');
            return Redirect::back()->with('error','Error al crear la solicitud de estudio anatomopatológico: ' . $e->getMessage());    
        }

    }
}
