<?php

namespace App\Http\Controllers\Formulario\HojaEnfermeriaQuirofano;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formulario\HojaEnfermeriaQuirofano\Isquemia\IsquemiaStoreRequest;
use Illuminate\Http\Request;

class IsquemiaController extends Controller
{
    public function store(IsquemiaStoreRequest $request)
    {
        $validatedData = $request->validated();
    }
}
