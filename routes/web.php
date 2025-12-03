<?php
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioHistoriaClinicaController;
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
use App\Http\Controllers\FormularioHojaGeneralController;
use App\Http\Controllers\FormularioNotaPostoperatorioController;
use App\Http\Controllers\HojaEnfemeriaQuirofanoController;
use App\Http\Controllers\SolicitudEstudioController;
use App\Http\Controllers\SolicitudEstudioPatologiaController;
use App\Http\Controllers\PreoperatoriaController;
use App\Http\Controllers\NotaUrgenciaController;
use App\Http\Controllers\NotasEgresoController;
use App\Http\Controllers\NotaEvolucionController;
use App\Http\Controllers\NotaPreAnestesicaController;
use App\Http\Controllers\NotaPostanestesicaController;

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
Route::resource('habitaciones', HabitacionController::class)->middleware('auth');
Route::resource('producto-servicios', ProductoServicioController::class)->middleware('auth');
Route::resource('pacientes', PacienteController::class)->middleware('auth');
Route::resource('doctores', DoctorController::class)->middleware('auth');  

Route::resource('pacientes.responsable', FamiliarResponsableController::class);
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->parameters(['hojasfrontales' => 'hojaFrontal'])->middleware('auth');
Route::resource('pacientes.estancias.historiasclinicas', FormularioHistoriaClinicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasenfermerias',FormularioHojaEnfermeriaController::class)->shallow()-> middleware('auth');
Route::resource('pacientes.estancias.ventas', VentaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.ventas.detallesventas',DetalleVentaController::class)->shallow()->middleware ('auth');
Route::resource('pacientes.estancias.interconsultas.honorarios', HonorarioController::class)->shallow();
Route::resource('pacientes.estancias.traslados', TrasladoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.preoperatorias', PreoperatoriaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasurgencias', NotaUrgenciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspostanestesicas',NotaPostanestesicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspostoperatorias', FormularioNotaPostoperatorioController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasegresos', NotasEgresoController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notasevoluciones', NotaEvolucionController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.notaspreanestesicas', NotaPreAnestesicaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasenfermeriasquirofanos',HojaEnfemeriaQuirofanoController::class)->shallow()->middleware('auth');

Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store');
Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


Route::prefix('pacientes/{paciente}/estancias/{estancia}')->group(function () {
    Route::get('notasegresos/create', [NotasEgresoController::class, 'create'])->name('pacientes.estancias.notasegresos.create');
    Route::post('notasegresos', [NotasEgresoController::class, 'store'])->name('pacientes.estancias.notasegresos.store');
    Route::get('notasegresos/{notaEgreso}', [NotaPreAnestesicaController::class, 'show'])->name('pacientes.estancias.notasegresos.show');
    // Agrega edit, update, etc. si los usas
});
Route::post('hojasterapiasiv/{hojasenfermeria}',[FormularioHojaTerapiaIVController::class,'store'])->name('hojasterapiasiv.store');
Route::patch('hojasterapiasiv/{hojasenfermeria}/{hojasterapiasiv}',[FormularioHojaTerapiaIVController::class,'update'])->name('hojasterapiasiv.update');

Route::post('hojasmedicamentos/{hojasenfermeria}',[FormularioHojaMedicamentoController::class, 'store'])->name('hojasmedicamentos.store');
Route::patch('hojasmedicamentos/{hojasenfermeria}/{hojasmedicamento}',[FormularioHojaMedicamentoController::class, 'update'])->name('hojasmedicamentos.update');


Route::get(
    '/pacientes/{paciente}/estancias/{estancia}/notas-urgencias/{notaUrgencia}',
    [NotaUrgenciaController::class, 'show']
)->name('pacientes.estancias.notasurgencias.show');


Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters(['interconsultas' => 'interconsulta']);
Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters(['interconsultas' => 'interconsulta']);

Route::post('hojassignos/{hojasenfermeria}',[FormularioHojaSignosController::class, 'store'])->name('hojassignos.store');

Route::post('dietas/{hojasenfermeria}',[FormularioHojaDietaController::class, 'store'])->name('dietas.store')->middleware('auth');

Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters(['interconsultas' => 'interconsulta']);


Route::post('hojassondascateters/{hojasenfermeria}',[FormularioHojaSondaCateterController::class, 'store'])->name('hojassondascateters.store')->middleware('auth');
Route::patch('hojassondascateters/{hojasenfermeria}/{hojassondascateter}',[FormularioHojaSondaCateterController::class, 'update'])->name('hojassondascateters.update')->middleware('auth');

// Rutas de lsa hoja de enfermería en quirofano

Route::post('hojasgenerals/{hojasenfermeria}',[FormularioHojaGeneralController::class, 'store'])->name('hojasgenerals.store')->middleware('auth');
Route::patch('hojasgenerals/{hojasenfermeria}/{hojasgeneral}',[FormularioHojaGeneralController::class, 'update'])->name('hojasgenerals.update')->middleware('auth');


// Rutas para estudios y patologías
Route::post('solicitudes-estudios/{estancia}', [SolicitudEstudioController::class, 'store'])->name('solicitudes-estudios.store');
Route::post('solicitudes-patologias/{estancia}', [SolicitudEstudioPatologiaController::class, 'store'])->name('solicitudes-patologias.store')->middleware('auth');
Route::post('solicitudes-patologias/{solicitud-patologia}/edit', [SolicitudEstudioPatologiaController::class, 'edit'])->name('solicitudes-patologias.edit')->middleware('auth');
Route::put('solicitudes-patologias/{estancia}', [SolicitudEstudioPatologiaController::class, 'update'])->name('solicitudes-patologias.update')->middleware('auth');
Route::post('solicitudes-patologias/{solicitud-patologia}/show', [SolicitudEstudioPatologiaController::class, 'show'])->name('solicitudes-patologias.show')->middleware('auth');


Route::resource('pacientes.estancias.interconsultas', InterconsultaController::class)
    ->shallow()
    ->parameters([
        'honorarios' => 'honorario',
        'interconsultas' => 'interconsulta'
    ]);

Route::get('pacientes/{paciente}/estancias/{estancia}/interconsultas/{interconsulta}', [InterconsultaController::class, 'show'])
->name('pacientes.estancias.interconsultas.show')
->middleware('auth');

//PDFs
Route::get('/hojasfrontales/{hojafrontal}/pdf', [FormularioHojaFrontalController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

Route::get('/historiasclinicas/{historiaclinica}/pdf', [FormularioHistoriaClinicaController::class, 'generarPDF'])
    ->name('historiasclinicas.pdf')
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

Route::get('/notaspostoperatorias/{notaspostoperatoria}/pdf', [FormularioNotaPostoperatorioController::class, 'generarPDF'])
    ->name('notaspostoperatorias.pdf')
    ->middleware('auth');

Route::get('/notasurgencias/{notasurgencia}/pdf', [NotaUrgenciaController::class, 'generarPDF'])
->name('notasurgencias.pdf')
->middleware('auth');

Route::get('/notasegresos/{notasegreso}/pdf', [NotasEgresoController::class, 'generarPDF'])
    ->name('notasegresos.pdf')
    ->middleware('auth');


Route::get('/solicitudes-patologias/{solicitudespatologia}/pdf', [SolicitudEstudioPatologiaController::class, 'generarPDF'])
    ->name('solicitudes-patologias.pdf')
    ->middleware('auth');

Route::get('/notaspreanestesicas/{notaspreanestesica}/pdf',[NotaPreAnestesicaController::class, 'generarPDF'])
    ->name('notaspreanestesicas.pdf')
    ->middleware('auth');
    
Route::get('/notaspostanestesicas/{notaspostanestesica}/pdf', [NotaPostanestesicaController::class, 'generarPDF'])
    ->name('notaspostanestesicas.pdf')
    ->middleware('auth');

Route::get('/notasevoluciones/{notasevolucione}/pdf', [NotaEvolucionController::class, 'generarPDf'])
    ->name('notasevoluciones.pdf')
    ->middleware('auth');

Route::get('/hojasenfermeriasquirofanos/{hojasenfermeriasquirofano}/pdf', [HojaEnfemeriaQuirofanoController::class, 'generarPDF'])
    ->name('hojasenfermeriasquirofanos.pdf')
    ->middleware('auth');

// Farmacia
Route::get('/farmacia/solicitudes/{hojaenfermeria}', [FarmaciaController::class, 'show'])
    ->name('farmacia.solicitud.show');
Route::patch('/medicamentos/{medicamento}/actualizar-estado', [HojaMedicamentoController::class, 'actualizarEstado'])
    ->name('medicamentos.actualizar-estado')
    ->middleware('auth');

// Notificaciones
Route::post('/notifications/mark-all-as-read', function () {
    Auth::user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('notifications.mark-all-as-read')->middleware('auth');

// Historial
Route::get('/historial', [HistoryController::class, 'index'])->name('historiales.index')->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
      