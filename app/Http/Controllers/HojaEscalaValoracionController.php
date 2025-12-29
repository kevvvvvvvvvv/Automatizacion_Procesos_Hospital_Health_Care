<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\HojaEscalaValoracion;
use App\Http\Requests\HojaEscalaValoracionRequest;
use App\Models\HojaEnfermeria;


class HojaEscalaValoracionController extends Controller
{
    public function store(HojaEscalaValoracionRequest $request,HojaEnfermeria $hojasenfermeria)
    {
        try{
            HojaEscalaValoracion::create([
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'fecha_hora_registro' => now(),
                ... $request->validated()
            ]);

            return Redirect::back()->with('success', 'Registro de escalas de valoración guardados exitosamente.');
        }catch(\Exception $e){
            Log::error('Error al guardar los signos: ' .$e->getMessage());
            return Redirect::back()->with('error','Error al guardar el registro de las escalas de valoración.');
        }

    }
}
