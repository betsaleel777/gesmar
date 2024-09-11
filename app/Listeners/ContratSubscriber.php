<?php

namespace App\Listeners;

use App\Enums\StatusFacture;
use App\Events\ContratRegistred;
use App\Events\ContratScheduled;
use App\Events\ContratSigned;
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
        $facture->montant_annexe = $event->montantAnnexe;
        $facture->codeGenerate(config('constants.ANNEXE_FACTURE_PREFIXE'));
        $facture->annexe_id = $event->contrat->annexe_id;
        $facture->save();
        $facture->proforma();
    }

    private function createFactureInitiale(ContratRegistred $event): void
    {
        $emplacement = Emplacement::with('type')->find($event->contrat->emplacement_id);
        $facture = new Facture();
        $facture->contrat_id = $event->contrat->id;
        $facture->codeGenerate(config('constants.INITIALE_FACTURE_PREFIXE'));
        $facture->caution = $emplacement->caution;
        $facture->avance = $event->avance * $emplacement->loyer;
        $facture->frais_dossier = $emplacement->type->frais_dossier;
        $facture->frais_amenagement = $emplacement->type->frais_amenagement;
        $facture->pas_porte = (int) $emplacement->pas_porte;
        $facture->save();
        $facture->proforma();
    }

    public function validerSansSigner(ContratScheduled $event): void
    {
        $event->contrat->validate();
        $event->contrat->codeContratGenerate();
        $event->contrat->save();
        $personne = Personne::findOrFail($event->contrat->personne_id);
        $personne->client();
        $emplacement = Emplacement::find($event->contrat->emplacement_id);
        $emplacement->occuper();
    }

    public function updateFactureStatus(FactureStatusChange $event): void
    {
        if ($event->status === StatusFacture::FACTURE) {
            $event->facture->facturable();
        }
    }

    public function createFacture(ContratRegistred $event): void
    {
        if ($event->contrat->isAnnexe()) {
            $this->createFactureAnnexe($event);
        } else {
            $event->contrat->auto_valid ?: $this->createFactureInitiale($event);
        }
    }

    public function updateAfterSigned(ContratSigned $event): void
    {
        $event->contrat->validate();
    }

    public function subscribe(): array
    {
        return [
            ContratRegistred::class => 'createFacture',
            FactureStatusChange::class => 'updateFactureStatus',
            ContratScheduled::class => 'validerSansSigner',
            ContratSigned::class => 'updateAfterSigned'
        ];
    }
}
