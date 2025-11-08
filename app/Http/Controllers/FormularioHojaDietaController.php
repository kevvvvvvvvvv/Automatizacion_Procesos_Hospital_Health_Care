<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\SolicitudDieta;

class FormularioHojaDietaController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria){
        dd($request->toArray());
        SolicitudDieta::create([
            'hoja_enfermeria_id' => $hojasenfermeria->id,
            'user_supervisa_id' => Auth::id(),
            'tipo_dieta' =>  $request,

            'horario_solicitud' => now(),
            'observaciones' => $request->observaciones,
        ]);
    }

    public function update(){

    }
}
