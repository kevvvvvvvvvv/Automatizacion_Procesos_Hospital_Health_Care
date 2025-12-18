<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PaymentController extends Controller
{
    public function purchase(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string'
        ]);

        $user = User::first(); 

        if (!$user) {
            return response()->json(['message' => 'No hay usuarios en la base de datos para probar'], 500);
        }
        $paymentMethod = $request->input('payment_method');

        try{
            $charge = $user->charge(10000, $paymentMethod, [
                'return_url' => 'http://127.0.0.1:3000/success', 
            ]);

            return Redirect::back()->with('success','Se ha realizado el pago');
        }catch(\Exception $e){
            Log::error('Error al generar el pago');
            return Redirect::back()->with('error','Error al realizar el pago');
        }
    }
}
