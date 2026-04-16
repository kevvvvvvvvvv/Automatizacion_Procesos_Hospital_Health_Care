<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\HojaRelevo\HojaRelevoRequest;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaEnfermeriaQuirofano;
use App\Models\Formulario\HojaEnfermeriaQuirofano\HojaRelevo;

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
            //Creacion del relevo
            HojaRelevo::create([
                ...$validatedData,

            ]);
            DB::commit();
            return Redirect::back()->with('success','Se ha generado el relevo.');
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Error al generar el relevo: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al generar el relevo.');
        }
    }
}
