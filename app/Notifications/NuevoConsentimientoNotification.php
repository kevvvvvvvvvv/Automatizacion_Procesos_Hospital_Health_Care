<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevoConsentimientoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }


public function store(Request $request)
{
    DB::beginTransaction();
    try {
        // 1. Guardas el consentimiento
        $consentimiento = Consentimiento::create($request->all());

        // 2. Buscas al médico (según tu modelo, es el que creó la estancia)
        $consentimiento->load('estancia.creator', 'estancia.paciente');
        $medico = $consentimiento->estancia->creator;

        // 3. ENVIAR NOTIFICACIÓN
        if ($medico) {
            $medico->notify(new NuevoConsentimientoNotification($consentimiento));
        }

        DB::commit();
        return Redirect::back()->with('success', 'Consentimiento creado y médico notificado.');
    } catch (\Exception $e) {
        DB::rollBack();
        return Redirect::back()->with('error', 'Error al guardar.');
    }
}
}
