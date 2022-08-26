<?php

namespace App\Listeners;

use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Models\Architecture\Equipement;

class AbonnementSubscriber
{
    public function makeEquipementSubscribed(AbonnementRegistred $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->emplacement_id = $event->abonnement->emplacement_id;
        $equipement->save();
        $equipement->abonner();
        $equipement->lier();
    }

    public function makeEquipementUnsubscribed(AbonnementResilied $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->desabonner();
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
            AbonnementRegistred::class,
            [$this, 'makeEquipementSubscribed']
        );
        $events->listen(
            AbonnementResilied::class,
            [$this, 'makeEquipementUnsubscribed']
        );
    }
}
