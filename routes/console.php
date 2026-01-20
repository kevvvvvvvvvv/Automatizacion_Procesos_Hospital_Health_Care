<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Reservacion;
use Illuminate\Support\Facades\Log;

Schedule::call(function () {
    // Buscamos las reservaciones que expiraron
    $expiradas = Reservacion::where('estatus', 'pendiente')
        ->where('created_at', '<', now()->subMinutes(10))
        ->get();

    foreach ($expiradas as $reserva) {
        // Al usar delete() en el modelo, Laravel se encarga de disparar 
        // eventos de eliminación si tienes lógica adicional.
        $reserva->delete(); 
        Log::info("Reservación #{$reserva->id} eliminada por falta de pago.");
    }
})->everyMinute();
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
