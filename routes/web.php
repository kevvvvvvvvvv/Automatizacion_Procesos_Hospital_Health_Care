<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\FormularioHojaFrontalController;
use App\Http\Controllers\FormularioInstanciaController;
use App\Models\Paciente;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('auth/login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard-healthcare');
    })->name('dashboard');
});

Route::resource('habitaciones',HabitacionController::class)->middleware('auth');
Route::resource('pacientes', PacienteController::class)->middleware('auth');
Route::resource('pacientes.estancias', EstanciaController::class)->shallow()->middleware('auth');
Route::resource('pacientes.estancias.hojasfrontales', FormularioHojaFrontalController::class)->shallow()->middleware('auth');




Route::get('/hojasfrontales/{hojafrontal}/pdf', [FormularioHojaFrontalController::class, 'generarPDF'])
    ->name('hojasfrontales.pdf')
    ->middleware('auth');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

