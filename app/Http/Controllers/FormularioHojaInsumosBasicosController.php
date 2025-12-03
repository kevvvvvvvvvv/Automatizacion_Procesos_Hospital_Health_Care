<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeriaQuirofano;
use App\Models\HojaInsumosBasicos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Log;

class FormularioHojaInsumosBasicosController extends Controller
{
    public function store(Request $request, HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
    {
        try{
            HojaInsumosBasicos::create([
                'producto_servicio_id' => $request->material_id,
                'hoja_enfermeria_quirofano_id' => $hojasenfermeriasquirofano->id,
                'cantidad' => $request->cantidad,
            ]);

            return Redirect::route('hojasenfermeriasquirofanos.edit', $hojasenfermeriasquirofano->id)->with('success','Se ha registrado el insumo.');
        }catch(\Exception $e){
            Log::error('Error al registrar el insumo: ' . $e);
            return Redirect::back()->with('error', 'Error al registrar el insumo.');
        }
    }

    public function update()
    {

    }
}
