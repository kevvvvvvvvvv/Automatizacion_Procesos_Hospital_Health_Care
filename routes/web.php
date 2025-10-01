<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EstanciaController;
use App\Http\Controllers\FormularioInstanciaController;
use App\Models\Paciente;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::resource('pacientes', PacienteController::class);
Route::resource('pacientes.estancias', EstanciaController::class)->shallow();
Route::resource('pacientes.estnacias.formularios', FormularioInstanciaController::class)->shallow();


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

