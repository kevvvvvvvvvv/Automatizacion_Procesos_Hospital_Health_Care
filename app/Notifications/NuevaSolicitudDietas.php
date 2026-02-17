<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Paciente;

use App\Models\SolicitudDieta;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NuevaSolicitudDietas extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    public $dieta;
    public $paciente;

    /**
     * Create a new notification instance.
     */
    public function __construct(SolicitudDieta $dieta, Paciente $paciente)
    {
        $this->dieta = $dieta;
        $this->paciente = $paciente;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = new MailMessage();

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $nombreCompleto = trim("{$this->paciente->nombre} {$this->paciente->apellido_paterno} {$this->paciente->apellido_materno}");
        $tipoDieta = $this->dieta->nombre_dieta ?? 'Dieta General';

        return [
            'title' => 'NUEVA DIETA', 
            'message' => "Se ha solicitado {$tipoDieta} para el paciente {$nombreCompleto}.",
            'dieta_id' => $this->dieta->id,
            'paciente_id' => $this->paciente->id,
            'paciente_nombre' => $nombreCompleto,
            'action_url' => "/dietas/{$this->dieta->id}/edit", 
            'action_text' => 'Ver solicitud'
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
