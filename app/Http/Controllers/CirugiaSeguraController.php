<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
//use App\Services\PdfGeneratorService;
use Redirect;
use App\Models\Formulario\FormularioCatalogo;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\CirugiaSegura\CirugiaSegura;
use App\Http\Requests\CirugiaSeguraRequest;
use App\Models\Paciente;
use App\Models\Estancia;
use Inertia\Inertia;
class CirugiaSeguraController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia){
    //dd($paciente->toArray());   
    return Inertia::render('CirugiaSegura/create', [
            'paciente' => $paciente,
            'estancia' => $estancia
        ]);
    }
    public function store(CirugiaSeguraRequest $request, Paciente $paciente, Estancia $estancia )
    {
        $validateData = $request->validated();
        DB::beginTransaction();
        try {
            $formularioinstancia = FormularioInstancia::create ([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => FormularioCatalogo::ID_CIRIGIA_SEGURA,
                'user_id' => Auth::id(),
            ]);
            $cirugiasegura = CirugiaSegura::create([
                'id' => $formularioinstancia->id,
                ...$validateData
            ]);
            DB::commit();
                return Redirect::route('estancias.show', $estancia->id)
                ->with('succes', 'Se ha registrado con exito la verificación de cirugpia segura'); 
        }catch (\Exception $e) {
                DB::rollback();
                \Log::error('Error en la verificación de cirugpia segura: '. $e->getMessage());
                return Redirect::back()->with('error', 'Error al crear la verificación: '. $e->getMessage());
        }
    }
}
