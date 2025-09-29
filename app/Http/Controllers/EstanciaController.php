<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estancia;
use Inertia\Inertia;

class EstanciaController extends Controller
{
    public function index()
    {
        
    }


    public function create()
    {


    }


    public function show($id)
    {
        $estancia = Estancia::findOrFail($id);
        dd($estancia);
        return Inertia::render('estancia/show',[
            'estancia' => $estancia
        ]);
    }
}
