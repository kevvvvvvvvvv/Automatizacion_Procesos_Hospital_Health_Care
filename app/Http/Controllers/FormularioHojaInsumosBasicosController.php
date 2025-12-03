<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaInsumosBasicosRequest;
use App\Models\HojaEnfermeriaQuirofano;
use App\Models\HojaInsumosBasicos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Log;

class FormularioHojaInsumosBasicosController extends Controller
{
    public function store(HojaInsumosBasicosRequest $request, HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
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

    public function update(HojaInsumosBasicosRequest $request, HojaInsumosBasicos $hojasinsumosbasico)
    {
        try{
            $hojasinsumosbasico->update($request->validated());
            return Redirect::back()->with('success','Se ha actualizado la hoja de insumos en quirófano.');
        }catch(\Exception $e){
            Log::error('Error al actualizar la hoja de insumos en quirófano: '. $e->getMessage());
            return Redirect::back()->with('error','Error al actualizar la hoja de insumos en quirófano.');
        } 
    }

    public function delete(HojaInsumosBasicos $hojasinsumosbasico)
    {
        try{
            $hojasinsumosbasico->delete();
            return Redirect::back()->with('success','Se ha eliminado el registro.');
        }catch(\Exception $e){
            Log::error('Error al eliminar el registro: '. $e->getMessage());
            return Redirect::back()->with('error','Error al eliminar el registro.');
        } 
    }
}
