<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Estancia;
use App\Models\FormularioInstancia; 
use App\Models\SolicitudEstudio;    

class SolicitudEstudioController extends Controller
{
    public function store(Request $request, Estancia $estancia)
    {
        dd($request->toArray());
    }
}
