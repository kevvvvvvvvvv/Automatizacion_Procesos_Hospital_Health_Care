<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaSignosRequest;
use Illuminate\Http\Request;
use App\Models\HojaEnfermeria;
use App\Models\HojaSignos;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class FormularioHojaSignosController extends Controller
{
    public function store(HojaSignosRequest $request,HojaEnfermeria $hojasenfermeria)
    {
        try{
            HojaSignos::create([
                'hoja_enfermeria_id' => $hojasenfermeria->id,
                'fecha_hora_registro' => now(),
                ... $request->validated()
            ]);

            return Redirect::back()->with('success', 'Signos guardados exitosamente.');
        }catch(\Exception $e){
            Log::error('Error al guardar los signos: ' .$e->getMessage());
            return Redirect::back()->with('error','Error al guardar los signos.');
        }

    }
}
