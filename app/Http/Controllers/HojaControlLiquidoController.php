<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HojaControlLiquido;
use App\Http\Requests\HojaControlLiquidoRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use App\Models\HojaEnfermeria;

class HojaControlLiquidoController extends Controller
{
    public function store(HojaControlLiquidoRequest $request,HojaEnfermeria $hojasenfermeria)
    {
        try{
            HojaControlLiquido::create([
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'fecha_hora_registro' => now(),
                ... $request->validated()
            ]);

            return Redirect::back()->with('success', 'Registro de control de liquidos guardados exitosamente.');
        }catch(\Exception $e){
            Log::error('Error al guardar los signos: ' .$e->getMessage());
            return Redirect::back()->with('error','Error al guardar el registro de control de liquidos.');
        }

    }
}
