<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureAnnexeController extends FactureController
{
    const RELATIONS = ['contrat.personne', 'contrat.site', 'annexe'];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isAnnexe()->isFacture()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesSoldees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonSoldees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isAnnexe()->find($id);
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
