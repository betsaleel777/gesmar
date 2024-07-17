<?php

namespace App\Listeners;

use App\Enums\StatusEmplacement;
use App\Enums\StatusEquipement;
use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Models\Architecture\Emplacement;
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
        $emplacement = Emplacement::find($event->abonnement->emplacement_id);
        $emplacement->liaison === StatusEmplacement::LINKED->value ?: $emplacement->lier();
        $contrat = $event->abonnement->load('emplacement:id', 'emplacement.contratPending')->emplacement->contratPending;
        if ($contrat) {
            $contrat->equipements()->updateExistingPivot($equipement->type, ['abonnable' => false]);
        }
    }

    public function subscribe(): array
    {
        return [
            AbonnementResilied::class => 'updateDependenciesAfterDelete',
            AbonnementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
