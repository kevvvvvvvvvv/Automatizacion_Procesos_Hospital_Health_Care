<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log;
use App\Models\Paciente;
use App\Models\Estancia;
use App\Models\Habitacion;
use App\Models\HojaFrontal;
use App\Models\ProductoServicio;
use App\Models\User;
use App\Observers\HistoryObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        DB::listen(function ($query) {
            Log::info(
                $query->sql,
                $query->bindings,
                $query->time
            );
        });

        Paciente::observe(HistoryObserver::class);
        Estancia::observe(HistoryObserver::class);
        User::observe(HistoryObserver::class);
        HojaFrontal::observe(HistoryObserver::class);
        ProductoServicio::observe(HistoryObserver::class);
        Habitacion::observe(HistoryObserver::class);

    }
}
