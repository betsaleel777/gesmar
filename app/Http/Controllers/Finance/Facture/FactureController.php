<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;

class FactureController extends Controller
{
    public function all(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->isPaid()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->isUnpaid()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('contrat.personne', 'contrat.site')->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function payer(int $id): JsonResponse
    {
        $facture = Facture::findOrFail($id);
        $facture->payer();
        $facture->save();
        $message = "La facture $facture->code a été payée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function getByContrat(int $id): JsonResponse
    {
        $facturesInitiales = Facture::with('contrat.emplacement', 'paiements')->where('contrat_id', $id)->isInitiale()->isFacture()->isSuperMarket()->get();
        $facturesInitiales->each(fn ($facture) => $facture->setAttribute('sommeVersee', $facture->paiements->sum('montant')));

        $facturesAnnexes = Facture::with('contrat.annexe', 'paiements')->where('contrat_id', $id)->isAnnexe()->isFacture()->get();
        $facturesLoyers = Facture::with('contrat.emplacement')->where('contrat_id', $id)->isLoyer()->isFacture()->get();
        $facturesEquipements = Facture::with('contrat.equipement.type')->where('contrat_id', $id)->isEquipement()->isFacture()->get();
        return response()->json([
            'facturesInitiales' => $facturesInitiales,
            'factureEquipements' => $facturesEquipements,
            'facturesLoyers' => $facturesLoyers,
            'facturesAnnexes' => $facturesAnnexes,
        ]);
    }
}
