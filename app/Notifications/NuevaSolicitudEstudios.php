<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Paciente;
use Illuminate\Support\Collection as EloquentCollection;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Channels\TwilioWhatsAppChannel; 

class NuevaSolicitudEstudios extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    public $estudios;
    public $paciente;
    public $solicitudId;

    public function __construct(EloquentCollection $estudios, Paciente $paciente, int $solicitudId)
    {
        $this->estudios = $estudios;
        $this->paciente = $paciente;
        $this->solicitudId = $solicitudId;
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail', TwilioWhatsAppChannel::class];
    }

    public function toWhatsApp($notifiable)
    {
        $listaEstudios = $this->estudios->map(function($item) {
             return $item->catalogoEstudio->nombre ?? 'Estudio General';
        })->implode(', ');

        return "*HOSPITAL NOTIFICACIÓN*\n" .
               "Hola *{$notifiable->name}*.\n" .
               "Nueva solicitud *#{$this->solicitudId}* para *{$this->paciente->nombre}*.\n\n" .
               "📋 *Estudios:*\n{$listaEstudios}\n\n" .
               "Favor de atender.";
    }

    public function toMail(object $notifiable): MailMessage
    {

        $nombreCompleto = trim("{$this->paciente->nombre} {$this->paciente->apellido_paterno} {$this->paciente->apellido_materno}");
        
        $primerEstudio = $this->estudios->first();
        $departamento = 'General';
        
        if ($primerEstudio) {
            $departamento = $primerEstudio->catalogoEstudio->departamento 
                            ?? $primerEstudio->detalles['departamento_manual'] 
                            ?? 'Estudios varios';

            $departamento = mb_strtoupper($departamento, 'UTF-8');
        }

        $url = url("/solicitudes-estudios/{$this->solicitudId}/edit");

        $mailMessage = (new MailMessage)
            ->subject("Nueva Solicitud de {$departamento} - Paciente: {$this->paciente->nombre}")
            ->greeting("Hola, {$notifiable->nombre}") 
            ->line("Se ha generado una nueva solicitud de estudios para el departamento de {$departamento}.")
            ->line("Paciente: **{$nombreCompleto}**")
            ->line("Estudios solicitados:");

        foreach ($this->estudios as $estudio) {
            $nombreEstudio = $estudio->catalogoEstudio->nombre ?? $estudio->otro_estudio;
            $mailMessage->line("- " . $nombreEstudio);
        }

        return $mailMessage
            ->action('Ingresar resultados', $url)
            ->line('Por favor, ingresa los resultados lo antes posible.');
    }

    public function toArray(object $notifiable): array
    {
        $nombreCompleto = trim("{$this->paciente->nombre} {$this->paciente->apellido_paterno} {$this->paciente->apellido_materno}");
        $primerEstudio = $this->estudios->first();
        $departamento = 'General';

        if ($primerEstudio) {
            $departamento = $primerEstudio->catalogoEstudio->departamento 
                            ?? $primerEstudio->detalles['departamento_manual'] 
                            ?? 'Estudios Varios';
        }

        $cantidad = $this->estudios->count();
        $mensajePrincipal = "Solicitud de {$departamento}: {$cantidad} estudio(s) para {$nombreCompleto}.";

        return [
            'solicitud_id' => $this->solicitudId, 
            'paciente_id' => $this->paciente->id,
            'paciente_nombre' => $nombreCompleto,
            'departamento' => $departamento,
            'cantidad_estudios' => $cantidad,
            'message' => $mensajePrincipal,
            'action_url' => "/solicitudes-estudios/{$this->solicitudId}/edit", 
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}