<?php

namespace App\Events;

use App\Models\Exploitation\Contrat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContratRegistred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $contrat;
    public $avance;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contrat $contrat, $avance = 0)
    {
        $this->contrat = $contrat;
        $this->avance = $avance;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
