<?php

namespace App\Listeners;

use App\Enums\StatusEquipement;
use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Models\Architecture\Equipement;

class AbonnementSubscriber
{
    public function updateDependenciesAfterDelete(AbonnementResilied $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->desabonner();
    }

    public function updateDependenciesAfterCreate(AbonnementRegistred $event): void
    {
        $equipement = Equipement::findOrFail($event->abonnement->equipement_id);
        $equipement->emplacement_id = $event->abonnement->emplacement_id;
        $equipement->save();
        $equipement->liaison === StatusEquipement::LINKED->value ?: $equipement->lier();
        $equipement->abonner();
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
            AbonnementResilied::class => 'updateDependenciesAfterDelete',
            AbonnementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
