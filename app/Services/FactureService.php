<?php

namespace App\Services;

use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Ordonnancement;
use App\Models\Exploitation\Paiement;
use Illuminate\Support\Collection;

class FactureService
{

    public function __construct(public Ordonnancement $ordonnancement)
    {
        $this->ordonnancement = $ordonnancement;
    }

    private static function checkForAnnexe(Paiement $paiement): bool
    {
        return false;
    }

    private function checkForBail(Collection $paiements): void
    {
        $contrat = Contrat::with('emplacement')->findOrFail($paiements->first()->facture->contrat_id);
        $emplacement = $contrat->emplacement;
        foreach ($paiements as $paiement) {
            $facture = $paiement->facture;
            if ($facture->isInitiale()) {
                $siFactureSoldee = $facture->pas_porte + $facture->caution * $emplacement->loyer === $paiement->montant;
                $siFactureSoldee ? $facture->payer() : $facture->impayer();
            } else {
                $facture->payer();
            }
        }
    }

    public function checkPaid(): void
    {
        $paiements = Paiement::with('facture')->where('ordonnancement_id', $this->ordonnancement->id);
        $paiementAnnexe = null;
        $paiementsBails = new Collection();
        foreach ($paiements as $paiement) {
            $paiement->facture->isAnnexe() ? $paiementAnnexe = $paiement : $paiementsBails->push($paiement);
        }
        !empty($paiementAnnexe) ? self::checkForAnnexe($paiementAnnexe) : $this->checkForBail($paiementsBails);
    }
}
