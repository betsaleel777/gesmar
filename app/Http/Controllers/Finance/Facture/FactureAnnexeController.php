<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureAnnexeController extends FactureController
{
    public function all(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isAnnexe()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesSoldees(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isPaid()->isAnnexe()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesNonSoldees(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isUnpaid()->isAnnexe()->get();

        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isAnnexe()->find($id);

        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Facture::RULES);
        $facture = new Facture($request->all());
        $facture->proforma();
        $facture->codeGenerate(ANNEXE_FACTURE_PREFIXE);
        $facture->save();
        $message = "La facture annexe: $facture->code a été crée avec succès.";

        return response()->json(['message' => $message]);
    }
}
