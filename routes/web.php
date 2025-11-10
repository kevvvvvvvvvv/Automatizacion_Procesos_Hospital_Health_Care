<?php
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioHistoriaClinicaController;
use App\Http\Controllers\FormularioInstanciaController;
use App\Http\Controllers\DoctorController; 
use App\Http\Controllers\ProductoServicioController;
use App\Http\Controllers\InterconsultaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\FamiliarResponsableController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\FormularioHojaEnfermeriaController;
use App\Http\Controllers\FormularioHojaMedicamentoController;
use App\Http\Controllers\HonorarioController;
use App\Http\Controllers\FormularioHojaTerapiaIVController;
use App\Http\Controllers\FormularioHojaSignosController;
use App\Http\Controllers\FarmaciaController;
use App\Http\Controllers\FormularioHojaSondaCateterController;
use App\Http\Controllers\FormularioHojaDietaController;
use App\Http\Controllers\HojaMedicamentoController;
use App\Http\Controllers\TrasladoController;
use App\Http\Controllers\AplicacionMedicamentoController;
use App\Http\Controllers\FormularioNotaPostoperatorioController;
use App\Http\Controllers\SolicitudEstudioController;
use App\Http\Controllers\PreoperatoriaController;
use App\Http\Controllers\NotaUrgenciaController;
use App\Models\History;
use App\Models\HojaTerapiaIV;
use App\Models\Interconsulta;
use App\Models\NotaPostoperatoria;
use App\Models\Paciente;
use App\Models\ProductoServicio;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return Inertia::render('auth/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard-healthcare');
    })->name('dashboard');
});

Route::post('/cargos', [CargoController::class, 'store'])->name('cargos.store');
Route::resource('habitaciones',HabitacionController::class)->middleware('auth');
Route::resource('producto-servicios',ProductoServicioController::class)->middleware('auth');
Route::resource('pacientes', PacienteController::class)->middleware('auth');
Route::resource('doctores', DoctorController::class)->middleware('auth');  

    Route::resource('pacientes.responsable', FamiliarResponsableController::class);
    Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
    Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->parameters(['hojasfrontales' => 'hojaFrontal'])->middleware('auth');
    Route::resource('pacientes.estancias.historiasclinicas', FormularioHistoriaClinicaController::class)->shallow()->middleware('auth');
    Route::resource('pacientes.estancias.hojasenfermerias',FormularioHojaEnfermeriaController::class)->shallow()-> middleware('auth');
    Route::resource('pacientes.estancias.ventas', VentaController::class)->shallow();
    Route::resource('pacientes.estancias.ventas.detallesventas',DetalleVentaController::class)->shallow()->middleware ('auth');
    Route::resource('pacientes.estancias.interconsultas.honorarios', HonorarioController::class)->shallow();
    Route::resource('pacientes.estancias.traslados', TrasladoController::class)->shallow()->middleware('auth');
    Route::resource('pacientes.estancias.preoperatorias', PreoperatoriaController::class)->shallow()->middleware('auth');
    Route::resource('pacientes.estancias.notasurgencias', NotaUrgenciaController::class)->shallow()->middleware('auth');


    Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store');
    Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update');
Route::resource('pacientes.responsable', FamiliarResponsableController::class);
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->parameters(['hojasfrontales' => 'hojaFrontal'])->middleware('auth');
Route::resource('pacientes.estancias.historiasclinicas', FormularioHistoriaClinicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasenfermerias',FormularioHojaEnfermeriaController::class)->shallow()-> middleware('auth');
Route::resource('pacientes.estancias.ventas', VentaController::class)->shallow();
Route::resource('pacientes.estancias.ventas.detallesventas',DetalleVentaController::class)->shallow()->middleware ('auth');
Route::resource('pacientes.estancias.interconsultas.honorarios', HonorarioController::class)->shallow();
Route::resource('pacientes.estancias.traslados', TrasladoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspostoperatorias', FormularioNotaPostoperatorioController::class)->shallow()->middleware('auth');

Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store');
Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update');

Route::post('hojasmedicamentos/{hojasenfermeria}',[FormularioHojaMedicamentoController::class, 'store'])->name('hojasmedicamentos.store');
Route::patch('hojasmedicamentos/{hojasenfermeria}/{hojasmedicamento}',[FormularioHojaMedicamentoController::class, 'update'])->name('hojasmedicamentos.update');

    Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store');
    
    Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
        ->shallow()
        ->parameters(['interconsultas' => 'interconsulta']);
Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store');

Route::post('dietas/{hojasenfermeria}',[FormularioHojaDietaController::class, 'store'])->name('dietas.store')->middleware('auth');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters(['interconsultas' => 'interconsulta']);


Route::post('hojassondascateters/{hojasenfermeria}',[FormularioHojaSondaCateterController::class, 'store'])->name('hojassondascateters.store');
Route::patch('hojassondascateters/{hojasenfermeria}/{hojassondascateter}',[FormularioHojaSondaCateterController::class, 'update'])->name('hojassondascateters.update');

Route::post('hoja-medicamentos/{hoja_medicamento}/aplicaciones', 
[AplicacionMedicamentoController::class, 'store'])
->name('aplicaciones.store');

// MANEJO DE ESTUDIOS

Route::post('solicitudes-estudios/{estancia}',[SolicitudEstudioController::class, 'store'])->name('solicitudes-estudios.store');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters([
        'honorarios' => 'honorario',
        'interconsultas' => 'interconsulta'
    ]);



Route::get('pacientes/{paciente}/estancias/{estancia}/interconsultas/{interconsulta}', [InterconsultaController::class, 'show'])
->name('pacientes.estancias.interconsultas.show')
->middleware('auth');





Route::put('/doctores/{doctor}', [DoctorController::class, 'update'])->name('doctores.update');

//PDFs
Route::get('/hojasfrontales/{hojafrontal}/pdf', [FormularioHojaFrontalController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

Route::get('/historiasclinicas/{historiaclinica}/pdf', [FormularioHistoriaClinicaController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

Route::get('/interconsultas/{interconsulta}/pdf', [InterconsultaController::class, 'generarPDF'])
    ->name('interconsultas.pdf')
    ->middleware('auth');

Route::get('/hojasenfermerias/{hojasenfermerias}/pdf', [FormularioHojaEnfermeriaController::class, 'generarPDF'])
    ->name('hojasenfermerias.pdf')
    ->middleware('auth');

Route::get('/traslados/{traslado}/pdf', [TrasladoController::class, 'generarPDF'])
    ->name('traslados.pdf')
    ->middleware('auth');

Route::get('/preoperatorias/{preoperatoria}/pdf', [PreoperatoriaController::class, 'generarPDF'])
    ->name('preoperatorias.pdf')
    ->middleware('auth');

Route::get('/hojasenfermerias/{hojasenfermerias}/pdf', [FormularioHojaEnfermeriaController::class, 'generarPDF'])
    ->name('hojasenfermerias.pdf')
    ->middleware('auth');

Route::get('/traslados/{traslado}/pdf', [TrasladoController::class, 'generarPDF'])
    ->name('traslados.pdf')
    ->middleware('auth');

Route::get('/notaspostoperatorias/{notaspostoperatoria}/pdf', [NotaPostoperatoria::class, 'generarPDF'])
    ->name('notaspostoperatorias.pdf')
    ->middleware('auth');

//Farmacia
Route::get('/farmacia/solicitudes/{hojaenfermeria}', [FarmaciaController::class, 'show'])
    ->name('farmacia.solicitud.show');

Route::patch('/medicamentos/{medicamento}/actualizar-estado', [HojaMedicamentoController::class, 'actualizarEstado'])
    ->name('medicamentos.actualizar-estado')
    ->middleware('auth');

//

//Notification

Route::post('/notifications/mark-all-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.mark-all-as-read')->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

