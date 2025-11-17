<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotaEvolucion;  // Asumiendo que tienes el modelo NotaEvolucion
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;
use App\Http\Requests\NotaEvolucionRequest;  // Crea este request si no existe
use Redirect;

class NotaEvolucionController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia)
    {
        return Inertia::render('formularios/notaevolucion/create', [
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function store(NotaEvolucionRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validateData = $request->validated();

        DB::beginTransaction();
        try {
            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => 12,  // Ajusta el ID del catálogo si es diferente
                'user_id' => Auth::id(),
            ]);

            $notaEvolucion = NotaEvolucion::create([
                'id' => $formularioInstancia->id,
                ...$validateData
            ]);

            DB::commit();

            return redirect()->route('pacientes.estancias.notasevoluciones.show', [
                'paciente' => $paciente->id,
                'estancia' => $estancia->id,
                'notaEvolucion' => $notaEvolucion->id,
            ])->with('success', 'Nota de Evolución creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al crear nota de evolución: ' . $e->getMessage());
        }
    }

    public function show(Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $notaEvolucion->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');

        return Inertia::render('formularios/notaevolucion/show', [
            'notaEvolucion' => $notaEvolucion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function edit(Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $notaEvolucion->load('formularioInstancia');

        return Inertia::render('formularios/notaevolucion/edit', [
            'notaEvolucion' => $notaEvolucion,
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }

    public function update(NotaEvolucionRequest $request, Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $validateData = $request->validated();

        $notaEvolucion->update($validateData);

        return redirect()->route('pacientes.estancias.notasevoluciones.show', [
            'paciente' => $paciente->id,
            'estancia' => $estancia->id,
            'notaEvolucion' => $notaEvolucion->id,
        ])->with('success', 'Nota de Evolución actualizada exitosamente.');
    }

    public function generarPDF(Paciente $paciente, Estancia $estancia, NotaEvolucion $notaEvolucion)
    {
        $notaEvolucion->load('formularioInstancia.estancia.paciente', 'formularioInstancia.user');

        $pdf = Pdf::loadView('pdf.notasEvoluciones', [
            'notaEvolucion' => $notaEvolucion,
            'paciente' => $notaEvolucion->formularioInstancia->estancia->paciente,
            'estancia' => $notaEvolucion->formularioInstancia->estancia,
        ]);

        return $pdf->download('nota_evolucion.pdf');
    }
}