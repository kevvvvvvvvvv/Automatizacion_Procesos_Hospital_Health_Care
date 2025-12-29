<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservacionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


