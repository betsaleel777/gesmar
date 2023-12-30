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
        $event->abonnement->index_depart === $event->abonnement->index_autre ? $event->abonnement->process() : $event->abonnement->error();
        $equipement = Equipement::find($event->abonnement->equipement_id);
        $equipement->emplacement_id = $event->abonnement->emplacement_id;
        $equipement->save();
        $equipement->liaison === StatusEquipement::LINKED->value ?: $equipement->lier();
        $equipement->abonner();
        $contrat = $event->abonnement->load('emplacement:id', 'emplacement.contratPending')->emplacement->contratPending;
        if ($contrat) {
            $contrat->equipements()->updateExistingPivot($equipement->type, ['abonnable' => false]);
        }
    }

    /**
     * Register the listeners for the subscriber.
     *@return array<class-name, string>
     */
    public function subscribe(): array
    {
        return [
            AbonnementResilied::class => 'updateDependenciesAfterDelete',
            AbonnementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
