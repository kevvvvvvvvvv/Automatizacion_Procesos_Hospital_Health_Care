<?php

namespace App\Http\Controllers\Formulario\HojaEnfemeria;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeria\EgresoLiquido\EgresoLiquidoRequest;
use App\Models\Formulario\HojaEnfermeria\EgresoLiquido;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EgresoLiquidoController extends Controller
{
    public function store(EgresoLiquidoRequest $request){
        $validatedData = $request->validated();

        try{
            EgresoLiquido::create([
                ...$validatedData
            ]);

            return Redirect::back()->with('success', 'Se ha guardado el egreso.');
        }catch(\Exception $e){
            \Log::error("Error al registrar el egreso: " .$e->getMessage());
            return Redirect::back()->with('error','Error al registrar el egreso.');
        }
    }
}
