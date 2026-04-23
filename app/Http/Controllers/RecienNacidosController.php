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
    $validated = $request->validate([
        'area'             => 'required|string',
        'nombre_rn'        => 'required|string|max:255',
        'sexo'             => 'required|string',
        'fecha_rn'         => 'required|date',
        'hora_rn'          => 'required',
        'peso'             => 'required|numeric',
        'talla'            => 'required|integer',
        'estado'           => 'required|string',
        'observaciones'    => 'nullable|string',
        'habitus_exterior' => 'nullable', // JSON o string
    ]);

    DB::beginTransaction();
    try {
        // 1. Crear la instancia del formulario
        $instancia = FormularioInstancia::create([
            'fecha_hora' => now(),
            'estancia_id' => $estancia->id,
            'formulario_catalogo_id' => FormularioCatalogo::ID_ENFERMERIA_RN,
            'user_id' => Auth::id(),
        ]);

        // 2. Crear el registro del Recién Nacido vinculado a la instancia
        $hoja = RecienNacido::create([
            'id'               => $instancia->id, // ID Compartido (One-to-One)
            'area'             => $validated['area'],
            'nombre_rn'        => $validated['nombre_rn'],
            'sexo'             => $validated['sexo'],
            'fecha_rn'         => $validated['fecha_rn'],
            'hora_rn'          => $validated['hora_rn'],
            'peso'             => $validated['peso'],
            'talla'            => $validated['talla'],
            'estado'           => $validated['estado'],
            'observaciones'    => $validated['observaciones'],
            'habitus_exterior' => $validated['habitus_exterior'] ?? null,
        ]);

        // OPCIONAL: Si quisieras registrar el peso/talla inicial 
        // automáticamente en la tabla de signos vitales (hoja_registros):
        /*
        $hoja->hoja_signos()->create([
            'fecha_hora_registro' => now(),
            'peso' => $validated['peso'],
            'talla' => $validated['talla'],
        ]);
        */

        DB::commit();

        return Redirect::route('reciennacido.edit', $hoja->id)
            ->with('success', 'Hoja de recién nacido iniciada correctamente.');

    } catch (\Exception $e) {
        DB::rollBack();
        //Log::error("Error al crear RN: " . $e->getMessage());
        return Redirect::back()->with('error', 'Error al guardar: ' . $e->getMessage());
    }
}
    public function edit(RecienNacido $reciennacido){
        if($reciennacido->estado == 'Cerrado') return redirect()->back()->with('error','La hoja de enfermeria de recien nacido se ha cerrado.');    
       
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
            'reciennacido' => $reciennacido,
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
            'hojaSignos',
            'hojasTerapiaIV.detalleSoluciones',
            'hojasTerapiaIV.medicamentos',
            'hojamedicamentos.productoServicio',
            'hojamedicamentos.aplicaciones',
            'somatometrias',
            'ingresos_egresos',

        );
        return $reciennacido;
    }
   public function update(Request $request, RecienNacido $reciennacido)
{
    $validated = $request->validate([
        'estado' => 'nullable|string',
        'observaciones' => 'nullable|string',
    ]);

    if ($reciennacido->estado === 'Cerrado' && $request->estado !== 'Abierto') {
        return Redirect::back()->with('error', 'Esta hoja ya está cerrada y no puede ser modificada.');
    }

    $reciennacido->update($validated);
    
    if ($request->estado === 'Cerrado') {
        $message = '¡Hoja de enfermería del recién nacido cerrada exitosamente!';
        return Redirect::route('estancias.show', $reciennacido->formularioInstancia->estancia_id)
                         ->with('success', $message);
    }

    return Redirect::back()->with('success', 'Hoja de enfermería actualizada.');
}
 public function generarPDF(RecienNacido $reciennacido)
    {
        $reciennacido = $this->getRelaciones($reciennacido);

        $headerData = [
            'hoja' => $reciennacido,
            'paciente' => $reciennacido->formularioInstancia->estancia->paciente,
            'estancia' => $reciennacido->formularioInstancia->estancia
        ];

        $viewData = [
            'notaData'=> $reciennacido,
            'medico'=> $reciennacido->formularioInstancia->user,
        ];

        return $this->pdfGenerator->generateStandardPdf(
            'pdfs.hoja-enfermeria-recien-nacido',
            $viewData,
            //$headerData,
            'hoja-enfermeria-recien-nacido',
            $reciennacido->formularioInstancia->estancia->id
        );

    }
}