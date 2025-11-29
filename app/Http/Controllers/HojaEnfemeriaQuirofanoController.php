<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioCatalogo;
use App\Models\FormularioInstancia;
use App\Models\HojaEnfermeriaQuirofano;
use App\Models\ProductoServicio;

class HojaEnfemeriaQuirofanoController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Redirect::route('pacientes.estancias.hojasenfermeriasquirofanos.store',[
            $paciente->id,
            $estancia->id
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        DB::beginTransaction();
        try{ 
            
            $instancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_HOJA_ENFERMERIA_QUIROFANO,
                'user_id' => Auth::id(),
            ]);

            $hoja = HojaEnfermeriaQuirofano::create([
                'id' => $instancia->id,
                'estado' => 'Abierto',
            ]);

            DB::commit();
            return Redirect::route('hojasenfermeriasquirofanos.edit', $hoja->id);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear la hoja de enfermería en quirófano: ' . $e);
            return Redirect::back()->with('error','Error al crear la hoja de enfermería en quirófano.');
        }       
    }

    public function edit(HojaEnfermeriaQuirofano $hojasenfermeriasquirofano)
    {
        $hojasenfermeriasquirofano->load(
            'formularioInstancia.estancia.paciente',
        );

        $insumos = ProductoServicio::where('tipo','INSUMOS')->get();

        return Inertia::render('formularios/hojas-enfermerias-quirofano/edit',[
            'paciente' => $hojasenfermeriasquirofano->formularioInstancia->estancia->paciente,
            'estancia' => $hojasenfermeriasquirofano->formularioInstancia->estancia,
            'hoja' => $hojasenfermeriasquirofano,
            'insumos' => $insumos
        ]);
    }

    public function update()
    {

    }

    public function generarPDF()
    {

    }

}
