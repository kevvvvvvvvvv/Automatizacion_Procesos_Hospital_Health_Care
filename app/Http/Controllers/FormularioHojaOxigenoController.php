<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaOxigenoRequest;
use App\Models\HojaEnfermeria;
use App\Models\HojaOxigeno;
use Illuminate\Http\Request;

class FormularioHojaOxigenoController extends Controller
{
    public function store(HojaOxigenoRequest $request,HojaEnfermeria $hojasenfermeria){
        
        $validatedData = $request->validated();  
        HojaOxigeno::create([
            'hoja_enfermeria_id'=>$hojasenfermeria->id,
            'hora_inicio' => now(),
            ...$validatedData
        ]);
    }

    public function update(){

    }
}
