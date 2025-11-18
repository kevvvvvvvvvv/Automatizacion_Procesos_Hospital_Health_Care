<?php

namespace App\Http\Controllers;

use App\Models\NotaPreAnestesica;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class NotaPreAnestesicaController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/notapreanestesica/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(Request $request, Paciente $paciente, Estancia $estancia)
    {
        $validated = $request->validate([
            'ta'  => ['nullable', 'string', 'max:50'],
            'fc'  => ['nullable', 'numeric'],
            'fr'  => ['nullable', 'numeric'],
            'peso' => ['nullable', 'numeric'],
            'talla' => ['nullable', 'numeric'],
            'temp' => ['nullable', 'numeric'],

            'resumen_del_interrogatorio' => ['nullable', 'string'],
            'exploracion_fisica' => ['nullable', 'string'],
            'diagnostico_o_problemas_clinicos' => ['nullable', 'string'],
            'plan_de_estudio' => ['nullable', 'string'],
            'pronostico' => ['nullable', 'string'],

            'plan_estudios_tratamiento' => ['nullable', 'string'],
            'evaluacion_clinica' => ['nullable', 'string'],
            'plan_anestesico' => ['nullable', 'string'],
            'valoracion_riesgos' => ['nullable', 'string'],
            'indicaciones_recomendaciones' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();

        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => NotaPreAnestesica::CATALOGO_ID,
                'user_id' => Auth::id(),
            ]);

            NotaPreAnestesica::create([
                'id' => $formularioInstancia->id,
                ...$validated,
            ]);

            DB::commit();

            return redirect()
                ->route('estancias.show', ['estancia' => $estancia->id])
                ->with('success', 'Nota preanestésica creada correctamente.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Error al crear la nota preanestésica: ' . $e->getMessage());
        }
    }
    public function show(Paciente $paciente, Estancia $estancia, NotaPreAnestesica $notaPreanestesica)
{
    $notaPreanestesica->load(
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user',
    );

    return Inertia::render('formularios/notapreanestesica/show', [
        'notaPreanestesica' => $notaPreanestesica,
        'paciente' => $notaPreanestesica->formularioInstancia->estancia->paciente,
        'estancia' => $notapreanestesica->estancia,
    ]);
}
public function generarPDF(){
    
}
}
