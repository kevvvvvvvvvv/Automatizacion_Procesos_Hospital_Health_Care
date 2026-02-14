<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
{
    // Esto trae TODO el historial de la tabla 'notifications' para el usuario
    $notificaciones = Auth::user()->notifications()->latest()->limit(50)->get();
    return Inertia::render('Notificaciones/index', [
        'notificaciones' => $notificaciones
    ]);
}

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Todas las notificaciones marcadas como leídas');
    }
    
}