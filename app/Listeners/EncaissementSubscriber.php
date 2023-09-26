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
        $event->ordonnancement->load('paiements.facture');
        $event->ordonnancement->payer();
        /** @var Contrat $contrat */
        $contrat = Contrat::with('personne', 'emplacement')->findOrFail($event->ordonnancement->paiements->first()->facture->contrat_id);
        $contrat->codeContratGenerate();
        $contrat->save();
        $contrat->status === StatusContrat::VALIDATED->value ?: $contrat->validated();
        $contrat->personne->status === StatusPersonne::CLIENT->name ?: $contrat->personne->client();
        if ($contrat->emplacement) $contrat->emplacement->occuper();
        $service = new FactureService($event->ordonnancement->paiements);
        $service->checkPaid();
        $autresContratsEnAttente = Contrat::where('emplacement_id', $contrat->emplacement_id)->inProcess()->get();
        $autresContratsEnAttente->map->delete();
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
