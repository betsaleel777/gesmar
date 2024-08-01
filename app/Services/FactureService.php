<?php

namespace App\Services;

use Illuminate\Support\Collection;

class FactureService
{

    public function __construct(public Collection $paiements)
    {
    }


    public function checkPaid(): void
    {
        $paiements = new Collection();
        foreach ($this->paiements as $paiement) {
            $paiements->push($paiement);
        }
        if (!$paiements->isEmpty()) {
            foreach ($paiements as $paiement) {
                $facture = $paiement->loadMissing('facture')->facture;
                if ($facture->isInitiale()) {
                    $facture->loadMissing('paiements');
                    $facture->getFactureInitialeTotalAmount() === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else if ($facture->isAnnexe()) {
                    $facture->loadMissing('paiements');
                    $facture->montant_annexe === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else if ($facture->isLoyer()) {
                    $facture->loadMissing('paiements');
                    $facture->montant_loyer === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else {
                    $facture->payer();
                }
            }
        }
    }
}
