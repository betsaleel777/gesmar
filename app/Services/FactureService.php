<?php

namespace App\Services;

use App\Models\Exploitation\Ordonnancement;
use Illuminate\Support\Collection;

class FactureService
{

    public function __construct(public Ordonnancement $ordonnancement)
    {}

    public function checkPaid(): void
    {
        $paiements = new Collection();
        $this->ordonnancement->loadMissing('paiements');
        foreach ($this->ordonnancement->paiements as $paiement) {
            $paiements->push($paiement);
        }
        if (!$paiements->isEmpty()) {
            $paiements->each(function ($paiement) {
                $facture = $paiement->loadMissing('facture')->facture;
                if ($facture->isInitiale()) {
                    $facture->loadMissing('paiements');
                    $facture->getFactureInitialeTotalAmount() === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else if ($facture->isAnnexe()) {
                    $facture->loadMissing('paiements');
                    $facture->montant_annexe === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else if ($facture->isLoyer()) {
                    $facture->loadMissing('paiements');
                    $facture->montant_loyer + $this->ordonnancement->timbre === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else {
                    $facture->payer();
                }
            });
        }
    }
}
