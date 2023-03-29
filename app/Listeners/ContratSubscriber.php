<?php

namespace App\Listeners;

use App\Enums\StatusFacture;
use App\Events\ContratRegistred;
use App\Events\ContratScheduled;
use App\Events\FactureStatusChange;
use App\Models\Architecture\Emplacement;
use App\Models\Exploitation\Personne;
use App\Models\Finance\Facture;

class ContratSubscriber
{
    private function createFactureAnnexe(ContratRegistred $event): void
    {
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(ANNEXE_FACTURE_PREFIXE);
        $facture->annexe_id = $event->contrat->annexe_id;
        $facture->save();
        $facture->proforma();
    }

    private function createFactureInitiale(ContratRegistred $event): void
    {
        $emplacement = Emplacement::with('type')->findOrFail($event->contrat->emplacement_id);
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(INITIALE_FACTURE_PREFIXE);
        $facture->caution = $emplacement->caution;
        $facture->avance = $event->avance;
        $facture->pas_porte = (int) $emplacement->pas_porte;
        $facture->save();
        $facture->proforma();
    }

    public function validerSansSigner(ContratScheduled $event): void
    {
        $event->contrat->validated();
        $personne = Personne::findOrFail($event->contrat->personne_id);
        $personne->client();
        $event->emplacement->occuper();
    }

    public function updateFactureStatus(FactureStatusChange $event): void
    {
        if ($event->status === StatusFacture::FACTURE) {
            $event->facture->facturable();
        }
    }

    public function createFacture(ContratRegistred $event): void
    {
        $event->contrat->isAnnexe() ? $this->createFactureAnnexe($event) : $this->createFactureInitiale($event);
    }

    /**
     * Register the listeners for the subscriber.
     *@return array<class-name, string>
     */
    public function subscribe(): array
    {
        return [
            ContratRegistred::class => 'createFacture',
            FactureStatusChange::class => 'updateFactureStatus',
            ContratScheduled::class => 'validerSansSigner'
        ];
    }
}
