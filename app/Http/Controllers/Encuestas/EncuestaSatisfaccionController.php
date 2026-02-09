<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estancia;
use Inertia\Inertia;

class EncuestaSatisfaccionController extends Controller
{

    public function create(Estancia $estancia){

        $estancia->load(
            'paciente'
        );

        return Inertia::render('formularios/encuestas-satisfacciones/create',[
            'estancia' => $estancia,
        ]);
    }

    public function store()
    {

    }
}
