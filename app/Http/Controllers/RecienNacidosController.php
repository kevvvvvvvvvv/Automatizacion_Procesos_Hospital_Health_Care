<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\RecienNacido;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\FormularioCatalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecienNacidosController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/recien-nacido/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        $request->validate([
            'area'      => 'required|string',
            'nombre_rn' => 'required|string|max:255',
            'sexo'      => 'required|string',
            'fecha_rn'  => 'required|date',
            'hora_rn'   => 'required',
            'peso'      => 'required|numeric',
            'talla'     => 'required|integer',
            'estado'    => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $instancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_ENFERMERIA_RN, // Asegúrate de tener este ID
                'user_id' => Auth::id(),
            ]);

            RecienNacido::create([
                'id'        => $instancia->id, // ID Compartido
                'area'      => $request->area,
                'nombre_rn' => $request->nombre_rn,
                'sexo'      => $request->sexo,
                'fecha_rn'  => $request->fecha_rn,
                'hora_rn'   => $request->hora_rn,
                'peso'      => $request->peso,
                'talla'     => $request->talla,
                'estado'    => $request->estado,
                'observaciones' => $request->observaciones,
                'habitus_exterior' => $request->habitus_exterior, // Si envías JSON desde el front
            ]);

            DB::commit();

            return Redirect::route('estancias.show', $estancia->id)
                ->with('success', 'Hoja de recién nacido iniciada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}