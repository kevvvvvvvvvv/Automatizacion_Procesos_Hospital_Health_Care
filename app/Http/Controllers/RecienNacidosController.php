<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Formulario\RecienNacido\RecienNacido;
use App\Models\Formulario\FormularioInstancia;
use App\Models\Formulario\FormularioCatalogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\PdfGeneratorService;
use App\Models\Inventario\ProductoServicio;
use App\Models\Inventario\CatalogoViaAdministracion;
use App\Models\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controllers\HasMiddleware;
use Inertia\Inertia;

class RecienNacidosController extends Controller
{
     use AuthorizesRequests;

    protected $pdfGenerator;

    public static function middleware(): array
    {
        $permission = \Spatie\Permission\Middleware\PermissionMiddleware::class;
        return [
            new Middleware($permission . ':consultar hojas enfermerias recien nacido', only: ['index', 'show', 'generarPDF']),
            new Middleware($permission . ':crear hojas enfermerias de recien nacido', only: ['create', 'store']),
            new Middleware($permission . ':eliminar hojas enfermerias de recien nacido', only: ['destroy']),
        ];
    }

    public function __construct(PdfGeneratorService $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }
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

            $hoja = RecienNacido::create([
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

            return Redirect::route('reciennacido.edit', $hoja->id)
                ->with('success', 'Hoja de recién nacido iniciada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
    public function edit(RecienNacido $reciennacido){
       // if($reciennacido->estado == 'Cerrado') return redirect()->back()->with('error','La hoja de enfermeria de recien nacido se ha cerrado.');    
       
        $reciennacido = $this->getRelaciones($reciennacido);
        $reciennacido->hoja_medicamentos = $reciennacido->hojaMedicamentos;
        $reciennacido->hoja_signos = $reciennacido->hojaSignos;
        $reciennacido->hoja_terapias = $reciennacido->hojasTerapiasIV;
       //dd($reciennacido);
        $estancia = $reciennacido->formularioInstancia->estancia;
        $paciente = $reciennacido->formularioInstancia->estancia->paciente;

        $medicamentos = ProductoServicio::where('subtipo','MEDICAMENTOS')->with('medicamento.viasAdministracion')->get();         
        $vias_administracion = CatalogoViaAdministracion::all();
        $soluciones = ProductoServicio::where('nombre_prestacion', 'like', 'SOLUCION%')->get();
        $medicos = User::all();
        $usuarios = User::all();
        $nota = $this->obtenerListaTratamiento($estancia);
       // dd($medicamentos->toArray());
        return Inertia::render('formularios/recien-nacido/edit',[
            'paciente' => $paciente,
            'estancia' => $estancia,
            'hoja' => $reciennacido, 
            'medicamentos' => $medicamentos,
            'soluciones' => $soluciones,
            'medicos' => $medicos,
            'usuarios' => $usuarios,

            'nota' =>$nota,
            'checklistInicial' => $nota ? $nota->checklistItems->where('is_completed', true)->values() : [],
            'vias_administracion' => $vias_administracion,
        ]);
    
    }
    private function obtenerListaTratamiento(Estancia $estancia){
        $notaPostoperatoria = $estancia->notasPostoperatorias()->latest()->first();
        $notaEvolucion = $estancia->notasEvoluciones()->latest()->first();

        $nota = null;

        if ($notaPostoperatoria && $notaEvolucion) {
            $nota = $notaPostoperatoria->created_at > $notaEvolucion->created_at 
                    ? $notaPostoperatoria 
                    : $notaEvolucion;
        } elseif ($notaPostoperatoria) {
            $nota = $notaPostoperatoria;
        } else {
            $nota = $notaEvolucion;
        }

        if ($nota) {
            $nota->load('checklistItems');
        }
        
        return $nota;
    }
    private function getRelaciones(RecienNacido $reciennacido)
    {
        $reciennacido->load(
            'formularioInstancia.user.credenciales',
            'formularioInstancia.user.colaborador_responsable.credenciales',
            'formularioInstancia.estancia.paciente', 
            'hojasTerapiasIV.detalleSoluciones',
            'hojasTerapiasIV.medicamentos',
            'hojaMedicamentos.productoServicio',
            'hojaMedicamentos.aplicaciones',
            'somatometrias',
            'Ingresos_Egresos_RN',

        );


        return $reciennacido;
        
    }
}