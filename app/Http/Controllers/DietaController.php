<?php

namespace App\Http\Controllers;

use App\Http\Requests\DietaRequest;
use App\Models\CategoriaDieta;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Dieta;
use Illuminate\Support\Facades\Redirect;

class DietaController extends Controller
{
    public function index()
    {
        $dieta = Dieta::all();
        $dieta->load('categoriaDieta');
        return Inertia::render('dietas/index',['dietas' => $dieta]);
    }

    public function create()
    {
        $dietas = CategoriaDieta::all();
        $dietas->load('categoriaDieta');

        return Inertia::render('dietas/create',['categoria_dietas' =>$dietas]);
    }

    public function store(DietaRequest $request)
    {
        $validatedData = $request->validated();
        try{
            Dieta::create($validatedData);
            return Redirect::route('dashboard')->with('success', 'Se ha creado la dieta.');
        }catch(\Exception $e){
            \Log::error("Error al registrar la dieta: " . $e->getMessage());
            return Redirect::back()->with('error','Error al registrar la dieta.');
        }
    }

    public function edit(Dieta $dieta)
    {
        $categoria = CategoriaDieta::all();

        return Inertia::render('dietas/edit', [ 
            'categoria_dietas' => $categoria,
            'dieta' => $dieta,
        ]);
    }

    public function update(DietaRequest $request, Dieta $dieta)
    {
        $validatedData = $request->validated();
        try{
            $dieta->update($validatedData);
            return Redirect::route('dashboard')->with('success', 'Se ha actualizado la dieta.');
        }catch(\Exception $e){
            \Log::error("Error al actualizar la dieta: " . $e->getMessage());
            return Redirect::back()->with('error','Error al actualizar la dieta.');
        }
       }
}
