<?php

namespace App\Http\Controllers;

use App\Http\Requests\HojaFrontalRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\FormularioCatalogo;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\HojaFrontal;
use App\Models\ProductoServicio;
use App\Models\Venta;
use App\Services\VentaService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class FormularioHojaFrontalController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia){
        $medicos = User::all();

        return Inertia::render('formularios/hojas-frontales/create',[
                                'paciente' => $paciente,
                                'estancia' => $estancia,
                                'medicos' => $medicos,]);
    }

    public function store(Paciente $paciente, Estancia $estancia, HojaFrontalRequest $request, VentaService $ventaService){
        DB::beginTransaction();
        try{

            $itemParaVenta = [  
                'id' => 661,
                'cantidad' => 1,
                'tipo' => 'producto'
            ];

            $ventaExistente = Venta::where('estancia_id', $estancia->id)
                        ->where('estado', Venta::ESTADO_PENDIENTE)
                        ->first();

            if ($ventaExistente) {
                $ventaService->addItemToVenta($ventaExistente, $itemParaVenta);
            } else {
                $ventaService->crearVenta([$itemParaVenta], $estancia->id, Auth::id());
            }

            $estancia->load(['paciente', 'creator', 'updater','formularioInstancias.catalogo','formularioInstancias.user']);

            $formularioInstancia = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => 1,
                'user_id' =>  Auth::id(),
            ]);

            HojaFrontal::create([
                'id' => $formularioInstancia->id,
                'medico' =>  $request->medico,
                'medico_id' => $request->medico_id,
                'responsable' => $request->responsable,
                'notas' => $request->notas
            ]);

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la hoja frontal exitosamente.');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear hoja frontal: ' . $e->getMessage());
            return Redirect::back()->with('error', 'No se pudo crear la hoja frontal.');
        }
    }


    public function edit(Paciente $paciente, Estancia $estancia, HojaFrontal $hojaFrontal)
    {
        $medicos = User::all();

        return Inertia::render('formularios/hojas-frontales/edit', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'medicos' => $medicos,
            'hojaFrontal' => $hojaFrontal, 
        ]);
    }

    public function update(HojaFrontalRequest $request, Paciente $paciente, Estancia $estancia, HojaFrontal $hojaFrontal)
    {
        $validatedData = $request->validated();
        $hojaFrontal->update($validatedData);

        if ($hojaFrontal->formularioInstancia) {
            $hojaFrontal->formularioInstancia()->update([
                'user_id' => Auth::id(),
            ]);
        }

        $estancia = $hojaFrontal->formularioInstancia->estancia;

        return Redirect::route('estancias.show', ['estancia' => $estancia])
            ->with('success', 'Hoja frontal actualizada exitosamente.');
    }
    public function show(HojaFrontal $hojaFrontal){
        $hojaFrontal->load([
            'formularioInstancia.estancia.paciente',
            'formularioInstancia.user',
            'medico',
        ]);
        return Inertia::render('formularios/hojas-frontales/show', [
            'paciente' => $hojaFrontal->formularioInstancia->estancia->paciente,
            'estancia' => $hojaFrontal->formularioInstancia->estancia,
            'hojaFrontal' => $hojaFrontal,
        ]);

    }

    public function generarPDF(HojaFrontal $hojafrontal)
    {
        $hojafrontal->load('formularioInstancia.estancia.paciente','formularioInstancia.estancia.familiarResponsable','medico.credencialesEmpleado');
        $estancia = $hojafrontal->formularioInstancia->estancia;
        $paciente = $estancia->paciente;
        $familiar_responsable = $hojafrontal->formularioInstancia->estancia->familiarResponsable;
        $medico = $hojafrontal->medico;

        return Pdf::view('pdfs.hoja_frontal', [
            'hojafrontal' => $hojafrontal,
            'estancia'    => $estancia,
            'paciente'    => $paciente,
            'medico'      => $medico,
            'familiar_responsable' => $familiar_responsable,
        ])
        ->withBrowsershot(function (Browsershot $browsershot) {
            $chromePath = config('services.browsershot.chrome_path');
            if ($chromePath) {
                $browsershot->setChromePath($chromePath);
                $browsershot->noSandbox();
                $browsershot->addChromiumArguments([
                    'disable-dev-shm-usage',
                    'disable-gpu',
                ]);
            } else {

            }
        })
        ->inline('hoja-frontal-' . $paciente->id . '.pdf');
    }

}
