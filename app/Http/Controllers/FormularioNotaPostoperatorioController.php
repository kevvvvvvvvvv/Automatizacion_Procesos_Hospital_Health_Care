<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaPostoperatoriaRequest;
use App\Models\CatalogoEstudio;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\NotaPostoperatoria;
use App\Models\PersonalEmpleado;
use App\Models\ProductoServicio;
use App\Models\TransfusionRealizada;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Arr;
use Auth;
use Spatie\LaravelPdf\Facades\Pdf;

class FormularioNotaPostoperatorioController extends Controller
{
    public function show()
    {

    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $personal = User::all();
        $soluciones = ProductoServicio::where('tipo','INSUMOS')->get();
        $medicamentos = ProductoServicio::where('tipo','INSUMOS')->get();
        $estudios = CatalogoEstudio::where('tipo_estudio','Laboratorio')->get();

        return Inertia::render('formularios/nota-postoperatorio/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'users' => $personal,
            'soluciones' => $soluciones,
            'medicamentos' => $medicamentos,
            'estudios' => $estudios,
        ]);
    }

    public function store(NotaPostoperatoriaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();
        dd($request->toArray());
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => NotaPostoperatoria::ID_CATALOGO,
                'user_id' => Auth::id(),
            ]);

            $nota = NotaPostoperatoria::create([
                'id' => $formulario->id,
                'user_id' => Auth::id(), 
                ...Arr::except($validatedData, [
                    'ayudantes_agregados', 
                    'transfusiones_agregadas'
                ])
            ]);

            if (!empty($validatedData['ayudantes_agregados'])) {
                foreach ($validatedData['ayudantes_agregados'] as $ayudante) {
                    $nota->personalEmpleados()->create([ 
                        'user_id' => $ayudante['ayudante_id'],
                        'cargo' => $ayudante['cargo'],
                    ]);
                }
            }

            if (!empty($validatedData['transfusiones_agregadas'])) {
                foreach ($validatedData['transfusiones_agregadas'] as $transfusion) {
                    $nota->transfusiones()->create([
                        'tipo_transfusion' => $transfusion['tipo_transfusion'], 
                        'cantidad' => $transfusion['cantidad'],
                    ]);
                }
            }

            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota postoperatoria');
        
        } catch(\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear nota postoperatoria: ' . $e->getMessage());
            return Redirect::back()->with('error','No se pudo crear la nota postoperatoria: ' . $e->getMessage());
        }
    }

    public function generarPDF(NotaPostoperatoria $notaspostoperatoria)
    {
        $notaspostoperatoria->load(
            'formularioInstancia.estancia',
            'formularioInstancia.user.credenciales',
            'personalEmpleados.user',
            'transfusiones'
        );

        $paciente = $notaspostoperatoria->formularioInstancia->estancia->paciente;
        $medico = $notaspostoperatoria->formularioInstancia->user;
        $estancia = $notaspostoperatoria->formularioInstancia->estancia;

        $logoDataUri = '';
        $imagePath = public_path('images/Logo_HC_2.png');
        if (file_exists($imagePath)) {
            $imageData = base64_encode(file_get_contents($imagePath));
            $imageMime = mime_content_type($imagePath);
            $logoDataUri = 'data:' . $imageMime . ';base64,' . $imageData;
        }

        $headerData = [
            'historiaclinica' => $notaspostoperatoria,
            'paciente' => $paciente,
            'logoDataUri' => $logoDataUri,
            'estancia' => $estancia
        ];

        //dd($notaspostoperatoria->toArray());
        return Pdf::view('pdfs.nota-postoperatoria',[
            'notaData' => $notaspostoperatoria,
            'medico' => $medico
        ])
        ->headerView('header', $headerData)
        ->inline('notas-postoperatorias');
    }
}
