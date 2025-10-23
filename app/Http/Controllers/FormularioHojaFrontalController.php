<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\FormularioCatalogo;
use App\Models\User;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\HojaFrontal;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\ProductoServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;

class FormularioHojaFrontalController extends Controller
{
    public function create(Paciente $paciente, Estancia $estancia){
         $medicos = User::where('cargo_id','2')->get();

        return Inertia::render('formularios/hojas-frontales/create',[
                                'paciente' => $paciente,
                                'estancia' => $estancia,
                                'medicos' => $medicos,]);
    }

    public function store(Paciente $paciente, Estancia $estancia, Request $request){

        DB::beginTransaction();
            try{

                $producto = ProductoServicio::findOrFail(661);
                $cantidad = 1;
                $subtotal = $producto->importe * $cantidad;
                $descuento = 0;
                $total = ($subtotal)*ProductoServicio::IVA - $descuento;

                $venta = Venta::create([
                    'fecha' => now(),
                    'subtotal' =>$subtotal,
                    'total' => $total,
                    'descuento' => $descuento,
                    'estado' => Venta::ESTADO_PENDIENTE,
                    'estancia_id' => $estancia->id,
                    'user_id' => Auth::id(),
                ]);

                DetalleVenta::create([
                    'precio_unitario' => $producto->importe,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'descuento' => $descuento,
                    'estado' => DetalleVenta::ESTADO_PENDIENTE,
                    'venta_id' => $venta->id,
                    'producto_servicio_id' => $producto->id,
                ]);

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

                return Inertia::render('estancias/show', [
                    'estancia' => $estancia,
                ]);

            }catch(\Exception $e){
                DB::rollBack();

                Log::error('Error al crear hoja frontal: ' . $e->getMessage());
                return redirect()->route('pacientes.estancias.hojasfrontales.index')->with('error', 'No se pudo crear la hoja frontal: ' . $e->getMessage());
            }
        }


    public function edit(Paciente $paciente, Estancia $estancia, HojaFrontal $hojaFrontal)
    {
        $medicos = User::where('cargo_id','2')->get();

        return Inertia::render('formularios/hojas-frontales/edit', [
            'paciente' => $paciente,
            'estancia' => $estancia,
            'medicos' => $medicos,
            'hojaFrontal' => $hojaFrontal, 
        ]);
    }

    public function update(Request $request, Paciente $paciente, Estancia $estancia, HojaFrontal $hojaFrontal)
    {
        $validatedData = $request->validate([
            'medico_id' => 'required|exists:users,id',
            'notas' => 'nullable|string',
        ]);

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
        ])->inline('hoja-frontal-' . $paciente->id . '.pdf');
    }

}
