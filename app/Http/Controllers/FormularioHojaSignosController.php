<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaSignosRequest;
use Illuminate\Http\Request;
use App\Models\HojaEnfermeria;
use App\Models\HojaSignos;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaSignosController extends Controller
{
    public function store(HojaSignosRequest $request,HojaEnfermeria $hojasenfermeria)
    {
    
        HojaSignos::create([
            'hoja_enfermeria_id' => $hojasenfermeria->id,
            'fecha_hora_registro' => now(),
            ... $request->validated()
        ]);

        return Redirect::back()->with('success', 'Signos guardados exitosamente.');
    }
}
