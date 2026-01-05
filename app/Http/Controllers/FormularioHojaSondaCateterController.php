<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaSondaCateteresRequest;
use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\HojaSondaCateter;

use Carbon\Carbon;

class FormularioHojaSondaCateterController extends Controller
{
    public function store(HojaSondaCateteresRequest $request, HojaEnfermeria $hojasenfermeria){

        $validatedData = $request->validated();
        $hojasenfermeria->load('formularioInstancia.estancia');
        
        try{
            HojaSondaCateter::create([
                ...$validatedData,
                'user_id' => Auth::id(),
                'hoja_enfermeria_id' => $hojasenfermeria->id
            ]);

            return Redirect::back()->with('success','Información guardada correctamente');

        }catch(\Exception $e){
            \Log::error('Error al registar la sonda o cateter: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al registar la sonda o cateter.');
        }
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
