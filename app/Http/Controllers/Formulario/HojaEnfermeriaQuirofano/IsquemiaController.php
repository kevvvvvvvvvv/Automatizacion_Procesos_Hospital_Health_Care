<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\Isquemia\IsquemiaStoreRequest;
use App\Models\Formulario\HojaEnfermeriaQuirofano\Isquemia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IsquemiaController extends Controller
{
    public function store(IsquemiaStoreRequest $request)
    {
        $validatedData = $request->validated();

        try{
            Isquemia::create(
                [...$validatedData]
            );

            return Redirect::back()->with('success','Se ha registrado la isquemia.');
        }catch(\Exception $e){
            \Log::error('Error durante el registro de la isquemia: ' .$e->getMessage());
            return Redirect::back()->with('error', 'Error durante el registro de la isquemia.');
        }
    }
}
