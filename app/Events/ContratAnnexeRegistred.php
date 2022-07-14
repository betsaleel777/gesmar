<?php

namespace App\Events;

use App\Models\Exploitation\Contrat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContratAnnexeRegistred
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $contrat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Contrat $contrat)
    {
        $this->contrat = $contrat;
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
