<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\HojaMedicamento;
use Illuminate\Support\Facades\Redirect;

class AplicacionMedicamentoController extends Controller
{
    public function store(Request $request, HojaMedicamento $hoja_medicamento)
    {
        $hoja_medicamento->aplicaciones()->create([
            'fecha_aplicacion' => now(),
            'user_id' => Auth::id(), 
        ]);

        return Redirect::back()->with('success', 'Aplicación registrada.');
    }
}
