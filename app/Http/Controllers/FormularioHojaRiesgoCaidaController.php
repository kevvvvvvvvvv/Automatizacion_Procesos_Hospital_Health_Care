<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaRiesgoCaidaRequest;
use App\Models\HojaEnfermeria;
use App\Models\HojaRiesgoCaida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaRiesgoCaidaController extends Controller
{
    public function store(HojaRiesgoCaidaRequest $request, HojaEnfermeria $hojasenfermeria){
        
        $validatedData = $request->validated();

        $validatedData['caidas_previas'] = filter_var($request->caidas_previas, FILTER_VALIDATE_BOOLEAN);

        try{

            $hojasenfermeria->hojaRiesgoCaida()->create([
                'caidas_previas' => $validatedData['caidas_previas'],
                'estado_mental'  => $validatedData['estado_mental'],
                'deambulacion'   => $validatedData['deambulacion'],
                'edad_mayor_70'  => $validatedData['edad_mayor_70'],
                
                'medicamentos'   => $validatedData['medicamentos'] ?? [], 
                'deficits'       => $validatedData['deficits'] ?? [],
                
                'puntaje_total'  => $validatedData['puntaje_total'],
            ]);

            return Redirect::back()->with('success', 'Se ha registrado el riesgo de caídas.');
        }catch(\Exception $e){
            \Log::error('Error al registrar el riesgo de caidas: ' . $e->getMessage());
            return Redirect::back()->with('error', 'Error al registrar el riesgo de caídas.');
        }
    }
}
