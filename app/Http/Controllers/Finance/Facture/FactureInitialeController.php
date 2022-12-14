<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureInitialeController extends Controller
{
    const RELATIONS = ['contrat.site', 'contrat.emplacement', 'contrat.personne'];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isSuperMarket()->isInitiale()->isFacture()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isSuperMarket()->isPaid()->isInitiale()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isSuperMarket()->isUnpaid()->isInitiale()->get();

        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isSuperMarket()->isInitiale()->find($id);

        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Facture::initialeRules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(INITIALE_FACTURE_PREFIXE);
        $facture->proforma();
        $facture->save();
        $message = "La facture initiale: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Facture::INITIALE_EDIT_RULES);
        $facture = Facture::findOrFail($id);
        $facture->update($request->all());
        $message = "La facture initiale: $facture->code a été modifiée avec succès.";
        return response()->json(['message' => $message]);
    }
}
