<?php

namespace App\Events;

use App\Models\Architecture\Equipement;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EquipementRegistred
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public Equipement $equipement, public int $ancienEmplacement=0)
    {
        $this->equipement = $equipement;
        $this->ancienEmplacement = $ancienEmplacement;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('channel-name');
    }
}
