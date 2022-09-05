<?php

namespace App\Listeners;

use App\Events\AbonnementResilied;
use App\Models\Architecture\Equipement;

class AbonnementSubscriber
{
    public function makeEquipementUnsubscribed(AbonnementResilied $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->desabonner();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events): array
    {
        return [
            AbonnementResilied::class => 'makeEquipementUnsubscribed'
        ];
    }
}
