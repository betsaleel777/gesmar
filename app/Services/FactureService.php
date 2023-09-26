<?php

namespace App\Services;

use App\Models\Exploitation\Contrat;
use App\Models\Exploitation\Paiement;
use App\Models\Finance\Facture;
use Illuminate\Support\Collection;

class FactureService
{

    public function __construct(public Collection $paiements)
    {
    }

    private static function checkForAnnexe(Paiement $paiement): bool
    {
        return false;
    }

    private static function checkForBail(Collection $paiements): void
    {
        if (!$paiements->isEmpty()) {
            $contrat = Contrat::with('emplacement')->findOrFail($paiements->first()->facture->contrat_id);
            $emplacement = $contrat->emplacement;
            foreach ($paiements as $paiement) {
                $facture = $paiement->facture;
                if ($facture->isInitiale()) {
                    $factureInitiale = Facture::with('paiements')->findOrFail($facture->id);
                    $total = $factureInitiale->paiements->sum('montant');
                    $siFactureSoldee = $facture->pas_porte + ($facture->caution + $facture->avance) * $emplacement->loyer === $total;
                    $siFactureSoldee ? $facture->payer() : null;
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
        !empty($paiementAnnexe) ? self::checkForAnnexe($paiementAnnexe) : self::checkForBail($paiementsBails);
    }
}
