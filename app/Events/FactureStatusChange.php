<?php

namespace App\Events;

use App\Models\Finance\Facture;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FactureStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $facture;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Facture $facture, string $status)
    {
        $this->facture = $facture;
        $this->status = $status;
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
