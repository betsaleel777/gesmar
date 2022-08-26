<?php

namespace App\Listeners;

use App\Events\EquipementRegistred;
use App\Models\Architecture\Emplacement;

class EquipementSubscriber
{
    public function makeStatusChange(EquipementRegistred $event): void
    {
        // delier l'ancien emplacement
        if (!empty($event->ancienEmplacement)) {
            $emplacement = Emplacement::findOrFail($event->ancienEmplacement);
            $emplacement->delier();
        }
        // lier le nouveau emplacement et aussi l'equipement en question
        if (!empty($event->equipement->emplacement_id)) {
            $event->equipement->lier();
            $emplacement = Emplacement::findOrFail($event->equipement->emplacement_id);
            $emplacement->lier();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events): void
    {
        $events->listen(
            EquipementRegistred::class,
            [EquipementSubscriber::class, 'makeStatusChange']
        );
    }
}
