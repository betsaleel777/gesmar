<?php

namespace App\Listeners;

use App\Enums\StatusContrat;
use App\Enums\StatusPersonne;
use App\Events\EncaissementRegistred;
use App\Models\Exploitation\Contrat;
use App\Services\FactureService;

class EncaissementSubscriber
{
    public function updateDependenciesAfterCreate(EncaissementRegistred $event): void
    {
        $event->ordonnancement->payer();
        $contrat = Contrat::with('personne', 'emplacement')->findOrFail($event->ordonnancement->paiements->first()->facture->contrat_id);
        $contrat->status === StatusContrat::VALIDATED->value ?: $contrat->validated();
        $contrat->personne->status === StatusPersonne::CLIENT->name ?: $contrat->personne->client();
        $contrat?->emplacement->occuper();
        $service = new FactureService($event->ordonnancement->paiements);
        $service->checkPaid();
    }

    /**
     * Register the listeners for the subscriber.
     * @return array<class-name, string>
     */
    public function subscribe(): array
    {
        return [
            EncaissementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
