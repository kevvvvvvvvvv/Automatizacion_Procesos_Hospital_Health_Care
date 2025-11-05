<?php

namespace App\Http\Controllers;

use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\HojaSondaCateter;

use Carbon\Carbon;

class FormularioHojaSondaCateterController extends Controller
{
    public function store(Request $request, HojaEnfermeria $hojasenfermeria){

        //dd($request->toArray());
        $validatedData = $request->validate([
            'tipo_dispositivo' => 'required | string',
            'calibre' => 'required | string',
            'fecha_instalacion' => 'nullable | date',
            'fecha_caducidad' => 'nullable | date',
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

    public function update(Request $request, HojaEnfermeria $hojasenfermeria, HojaSondaCateter $hojassondascateter)
    {
        $data = $request->all();

        if ($request->has('fecha_instalacion') && $request->fecha_instalacion) {
            $data['fecha_instalacion'] = Carbon::parse($request->fecha_instalacion)
                                            ->setTimezone(config('app.timezone'));
        }

        if ($request->has('fecha_caducidad') && $request->fecha_caducidad) {
            $data['fecha_caducidad'] = Carbon::parse($request->fecha_caducidad)
                                            ->setTimezone(config('app.timezone'));
        }
        
        if ($request->has('observaciones')) {
            $data['observaciones'] = $request->observaciones;
        }

        $hojassondascateter->update($data);

        return Redirect::back()->with('success', 'Registro actualizado');
    }

}
