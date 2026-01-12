<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaHabitusExteriorRequest;
use App\Models\HojaEnfermeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FormularioHojaHabitusExteriorController extends Controller
{
    public function store(HojaHabitusExteriorRequest $request, HojaEnfermeria $hojasenfermeria)
    {
        $validatedData = $request->validated();
        try{
            $hojasenfermeria->hojaHabitusExterior()->create($validatedData);
            return Redirect::back()->with('success','Se ha registrado el habitus exterior.');
        }catch(\Exception $e){
            \Log::error('Error al registrar el habitus exterior: ' . $e->getMessage());
            return Redirect::back()->with('error','Error al registrar el habitus exterior.');
        }
    }
}
