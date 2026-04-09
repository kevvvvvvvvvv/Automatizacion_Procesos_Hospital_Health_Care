<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\ConteoMaterialQuirofanoRequest;
use App\Models\Formulario\HojaEnfermeriaQuirofano\ConteoMaterialQuirofano;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaEnfermeriaQuirofano;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class ConteoMaterialQuirofanoController extends Controller
{
    public function store(ConteoMaterialQuirofanoRequest $request, HojaEnfermeriaQuirofano $hojasenfermeriasquirofano){
        $validatedData = $request->validated();

        DB::beginTransaction();
        try{
            ConteoMaterialQuirofano::where('hoja_enfermeria_quirofano_id', $hojasenfermeriasquirofano->id)->delete();

            foreach ($validatedData['conteo_materiales'] as $material) {
                ConteoMaterialQuirofano::create([
                    'hoja_enfermeria_quirofano_id' => $hojasenfermeriasquirofano->id,
                    'tipo_material'     => $material['tipo_material'],
                    'cantidad_inicial'  => $material['cantidad_inicial'],
                    'cantidad_agregada' => $material['cantidad_agregada'],
                    'cantidad_final'    => $material['cantidad_final'],
                ]);
            }
            DB::commit();
            return Redirect::back()->with('success','Se ha cargado el material.');
        }catch (\Exception $e){
            DB::rollback();
            \Log::error('Error en la carga del material en la hoja de enfermeria en quirofano: ' .$e->getMessage());
            return Redirect::back()->with('error','Error en la carga del material.');
        }
    }
}
