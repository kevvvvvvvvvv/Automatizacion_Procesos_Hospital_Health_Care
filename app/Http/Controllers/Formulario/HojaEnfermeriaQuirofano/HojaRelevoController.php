<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\HojaRelevo\HojaRelevoRequest;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaEnfermeriaQuirofano;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaRelevo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class HojaRelevoController extends Controller
{
    public function store(HojaRelevoRequest $request, HojaEnfermeriaQuirofano $hoja)
    {  
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {

            $this->marcarHoraSalida($hoja);

            HojaRelevo::create([
                ...$validatedData,
                'hoja_enfermeria_quirofano_id' => $hoja->id,
                'hora_entrada' => now(),
            ]);
            DB::commit();
            return Redirect::back()->with('success','Se ha generado el relevo.');
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Error al generar el relevo: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al generar el relevo.');
        }
    }

    public function marcarHoraSalida(HojaEnfermeriaQuirofano $hoja): Void
    {
        $hoja_relevo = HojaRelevo::where('hoja_enfermeria_quirofano_id',$hoja->id)
            ->where('hora_salida',null)
            ->first();

        if($hoja_relevo){
            $hoja_relevo->update([
                'hora_salida' => now()
            ]);
        }
    }

}
