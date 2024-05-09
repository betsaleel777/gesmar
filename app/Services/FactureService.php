<?php

namespace App\Services;

use App\Models\Finance\Facture;
use Illuminate\Support\Collection;

class FactureService
{

    public function __construct(public Collection $paiements)
    {
    }

    // private static function checkForAnnexe(Paiement $paiement): void
    // {
    //     $paiement->facture;
    // }

    private static function checkForBail(Collection $paiements): void
    {
        if (!$paiements->isEmpty()) {
            foreach ($paiements as $paiement) {
                $facture = $paiement->loadMissing('facture')->facture;
                if ($facture->isInitiale()) {
                    $facture->loadMissing('paiements');
                    // vérifier si la facture est soldée
                    $facture->getFactureInitialeTotalAmount() === $facture->paiements->sum('montant') ? $facture->payer() : null;
                } else {
                    $facture->payer();
                }
            }
        }
    }

    public function checkPaid(): void
    {
        $paiementAnnexe = null;
        $paiementsBails = new Collection();
        foreach ($this->paiements as $paiement) {
            $paiement->facture->isAnnexe() ? $paiementAnnexe = $paiement : $paiementsBails->push($paiement);
        }
        !empty($paiementAnnexe) ? $paiementAnnexe->facture->payer() : self::checkForBail($paiementsBails);
    }
}
