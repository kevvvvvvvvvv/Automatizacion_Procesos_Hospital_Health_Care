<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use App\Models\Paciente;

class MedicamentosSolicitados implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Collection $medicamentos;
    public Paciente $paciente;

    public function __construct(Collection $medicamentos, Paciente $paciente)
    {
        $this->medicamentos = $medicamentos;
        $this->paciente = $paciente;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('farmacia'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'nueva-solicitud-medicamentos';
    }
}
