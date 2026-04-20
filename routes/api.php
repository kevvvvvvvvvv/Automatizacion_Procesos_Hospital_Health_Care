<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cajero\WebhookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/v1/pago-cajero', [WebhookController::class, 'recibirPago']);

//Obtener informacion del municipio en base a CP
Route::get('/sepomex/{cp}', function ($cp) {
    $datos = DB::table('sepomex_data')
        ->where('d_codigo', $cp)
        ->get(['d_asenta', 'D_mnpio', 'd_estado']); 

    return response()->json($datos);
});