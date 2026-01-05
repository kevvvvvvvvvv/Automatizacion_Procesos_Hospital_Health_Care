<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaDietaRequest;
use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\SolicitudDieta;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaDietaController extends Controller
{
    public function store(HojaDietaRequest $request, HojaEnfermeria $hojasenfermeria){
        
        $validatedData = $request->validated();
        
        try{
            SolicitudDieta::create([
                ... $validatedData,
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'horario_solicitud' => now(),
            ]);

            return Redirect::back()->with('success','Se ha enviado la solicitud de dieta');
        }catch(\Exception $e)
        {
            \Log::error('Error al crear la solicitd de dieta: '. $e->getMessage());
            return Redirect::back()->with('error','Error al crear la solicitd de dieta.');
        }
    }

    public function update(){

    }
}
