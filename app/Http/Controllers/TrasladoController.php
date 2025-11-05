<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Traslado;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

use App\Http\Requests\TrasladoRequest;

// use Illuminate\Http\Request;

class TrasladoController extends Controller
{
    //
    public function index()
    {
        //
    }

    public function create(Paciente $paciente, Estancia $estancia)     
    {
       
        return Inertia::render('formularios/traslado/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
        ]);
    }
    public function store(Paciente $paciente, Estancia $estancia, TrasladoRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        $formularioInstancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => 6,
            'user_id' => Auth::id(),
        ]);
        $traslado = Traslado::create([
            'id' => $formularioInstancia->id,
            ...$validatedData
        ]);
        //dd($traslado->toArray());
        DB::commit();
        
        return redirect()->route('estancias.show', [
            'estancia' => $estancia->id,
        ])->with('success', 'Traslado creado exitosamente.');
    }


    public function show(Paciente $paciente, Estancia $estancia, Traslado $traslado)
{ 
    $traslado->load([
        'formularioInstancia.estancia.paciente',
        'formularioInstancia.user',
    ]);

    // Verificación para evitar null
    if (!$traslado->formularioInstancia || !$traslado->formularioInstancia->estancia || !$traslado->formularioInstancia->estancia->paciente) {
        abort(404, 'Datos del traslado no encontrados.');
    }

    return Inertia::render('formularios/traslado/show', [
        'traslado' => $traslado,
        'paciente' => $traslado->formularioInstancia->estancia->paciente,
        'estancia' => $traslado->formularioInstancia->estancia,
    ]);
}

    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
    public function generarPDF(Traslado $traslado)
    {
       
        $traslado->load([
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
        ]);
        $paciente = $traslado->formularioInstancia->estancia->paciente;
        $medico = $traslado->formularioInstancia->user;
        $estancia = $traslado->formularioInstancia->estancia;
         
        $logoDataUri = '';
        $imagePath = public_path('images/Logo_HC_2.png');
         if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            $logoDataUri = 'data:' . $imageMime . ';base64,' . $imageData;
        }
        $headerData = [
            'historiaclinica' => $traslado,
            'paciente' => $paciente,
            'logoDataUri' => $logoDataUri,
            'estancia' => $estancia
        ];
        return Pdf::view('pdfs.traslado', [
            'notaData' => $traslado,
            'paciente' => $paciente,
            'medico' => $medico
        ])
        ->headerView('header', $headerData)
        ->inline('traslado.pdf');

    }
}
