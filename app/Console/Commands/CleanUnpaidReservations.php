<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:clean-unpaid-reservations')->everyMinute();

class CleanUnpaidReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-unpaid-reservations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   public function handle()
{
    // Buscamos reservaciones 'pendientes' creadas hace más de 10 minutos
    $expiradas = \App\Models\Reservacion::where('estatus', 'pendiente')
        ->where('created_at', '<', now()->subMinutes(10))
        ->get();

    foreach ($expiradas as $reserva) {
        // Al usar delete() se eliminan también los registros relacionados 
        // si tienes configurado el "onDelete cascade" en la BD
        $reserva->delete(); 
    }

    $this->info('Reservaciones expiradas limpiadas con éxito.');
}
}
