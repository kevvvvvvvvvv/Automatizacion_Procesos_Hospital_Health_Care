<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\HojaSondaCateter;

class FormularioHojaSondaCateterController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria){

        //dd($request->toArray());
        $validatedData = $request->validate([
            'tipo_dispositivo' => 'required | string',
            'calibre' => 'required | string',
            'fecha_instalacion' => 'required | date',
            'fecha_caducidad' => 'required | date',
            'observaciones' => 'nullable | string'
        ]);

        $hojasenfermeria->load('formularioInstancia.estancia');

        HojaSondaCateter::create([
            ...$validatedData,
            'user_id' => Auth::id(),
            'estancia_id' => $hojasenfermeria->formularioInstancia->estancia->id
        ]);


        return Redirect::back()->with('success','Información guardada correctamente');
    }

}
