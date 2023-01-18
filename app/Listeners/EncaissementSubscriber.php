<?php

namespace App\Listeners;

use App\Events\EncaissementRegistred;
use App\Models\Exploitation\Contrat;

class EncaissementSubscriber
{
    public function updateDependenciesAfterCreate(EncaissementRegistred $event): void
    {
        $event->ordonnancement->payer();
        $contrat = Contrat::with('personne', 'emplacement')->findOrFail($event->ordonnancement->paiements->first()->facture->contrat_id);
        $contrat->validated();
        $contrat->personne->client();
        $contrat?->emplacement->occuper();
        // facture soldé oui ou non
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
            EncaissementRegistred::class => 'updateDependenciesAfterCreate',
        ];
    }
}
