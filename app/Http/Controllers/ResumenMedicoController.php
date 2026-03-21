<?php

namespace App\Http\Controllers;

use App\Models\ResumenMedico;
use App\Models\Estancia;
use Illuminate\Http\Request;
use App\Models\Paciente;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ResumenMedicoController extends Controller
{
    public function store(Request $request, Estancia $estancia)
    {

        $validated = $request->validate([
            'resumen' => 'required|string|min:10',
        ]);

        ResumenMedico::create([
            'resumen_medico' => $validated['resumen'],
            'estancia_id'    => $estancia->id,
            'user_id'        => auth()->id(), 
        ]);

        return Redirect::route('estancias.show', $estancia->id)
            ->with('message', 'Resumen médico creado correctamente');
    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/Resumen-medico/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
}