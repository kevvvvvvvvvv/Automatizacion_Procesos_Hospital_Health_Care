<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\CatalogoPregunta;

class FormularioHistoriaClinicaController extends Controller
{
    public function create()
    {
        $preguntas = CatalogoPregunta::where('formulario_catalogo_id', 2)
                                      ->orderBy('orden')
                                      ->get(['id', 'pregunta', 'categoria']);

        
        return Inertia::render('formularios/historias-clinicas/create',[
            'preguntas' => $preguntas
        ]);
    }
}
