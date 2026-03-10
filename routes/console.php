<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

use App\Models\Reservacion\ReservacionConsultorio\Reservacion;

Schedule::call(function () {
    $expiradas = Reservacion::where('estatus', 'pendiente')
        ->where('created_at', '<', now()->subMinutes(10))
        ->get();

    foreach ($expiradas as $reserva) {
        $reserva->delete(); 
        Log::info("Reservación #{$reserva->id} eliminada por falta de pago.");
    }
})->everyMinute();
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
