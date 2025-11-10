<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotaPostoperatoriaRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\FormularioInstancia;
use App\Models\NotaPostoperatoria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Auth;

class FormularioNotaPostoperatorioController extends Controller
{
    public function show()
    {

    }

    public function create(Paciente $paciente, Estancia $estancia)
    {
        $personal = User::all();

        return Inertia::render('formularios/nota-postoperatorio/create',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'users' => $personal,
        ]);
    }

    public function store(NotaPostoperatoriaRequest $request, Paciente $paciente, Estancia $estancia)
    {
        $validatedData = $request->validated();
        ;
        DB::beginTransaction();
        try{
            $formulario = FormularioInstancia::create([
                'fecha_hora' => now(),
                'estancia_id' => $estancia->id,
                'formulario_catalogo_id' => NotaPostoperatoria::ID_CATALOGO,
                'user_id' => Auth::id(),
            ]);

            NotaPostoperatoria::create([
                'id' => $formulario->id,
                ... $validatedData
            ]);
            DB::commit();
            return Redirect::route('estancias.show', $estancia->id)->with('success','Se ha creado la nota postoperatoria');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Error al crear hoja frontal: ' . $e->getMessage());
            return Redirect::back()->with('error','No se pudo crear la nota postoperatoria ' . $e);

        }
    }

    public function generarPDF(NotaPostoperatoria $notaspostoperatoria){


    }
}
