<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaOxigenoRequest;
use App\Models\Estancia;
use App\Models\HojaEnfermeria;
use App\Models\HojaOxigeno;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FormularioHojaOxigenoController extends Controller
{
    public function store(HojaOxigenoRequest $request, Estancia $estancia){

        try{
            HojaOxigeno::create([
                'hora_inicio' => now(),
                'estancia_id' => $estancia->id,
                'litros_minuto' =>$request->litros_minuto,
                'user_id_inicio' => Auth::id(),
            ]);

            return Redirect::back()->with('success','Se ha registrado la hora de inicio del uso de oxígeno');
        }catch(\Exception $e){
            Log::error('Error al registrar la hora de incio del uso de oxígeno: ' . $e);
            return Redirect::back()->with('error','Error al registrar la hora de incio del uso de oxígeno.');
        }
    }

    public function update(HojaOxigenoRequest $request,HojaOxigeno $hojasoxigeno){
        $validatedData=$request->validated();
        $validatedData['hora_fin'] = Carbon::parse($validatedData['hora_fin'])->setTimezone(config('app.timezone'));
        try{
            $hojasoxigeno->update($validatedData);
            return Redirect::back()->with('success','Se ha registrado la hora de fin del uso de oxígeno');
        }catch(\Exception $e){
            Log::error('Error al registrar la hora de fin del uso de oxígeno: ' . $e);
            return Redirect::back()->with('error','Error al registrar la hora de fin del uso de oxígeno.');
        }
        
    }
}
