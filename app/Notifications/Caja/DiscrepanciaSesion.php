<?php

namespace App\Notifications\Caja;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

use App\Models\Caja\SesionCaja;

class DiscrepanciaSesion extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public SesionCaja $sesion,
        public float $diferencia
    ) {}

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
    public function toArray($notifiable): array
    {
        $tipoError = $this->diferencia < 0 ? 'FALTANTE' : 'SOBRANTE';
        $montoAbsoluto = number_format(abs($this->diferencia), 2);

        return [
            'title' => "DESCUADRE: $tipoError", 
            'message' => "La {$this->sesion->caja->nombre} registró una diferencia de $$montoAbsoluto.",
            'type' => 'warning', 
            'action_url' => "tesoreria/boveda?tab=sesiones",
            'action_text' => 'Auditar sesión',
        
            'sesion_id' => $this->sesion->id,
            'cajero_nombre' => $this->sesion->user->nombre_completo,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
