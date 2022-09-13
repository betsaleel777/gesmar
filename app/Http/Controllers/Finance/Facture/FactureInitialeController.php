<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureInitialeController extends Controller
{
    public function all(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isSuperMarket()->isInitiale()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isSuperMarket()->isPaid()->isInitiale()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isSuperMarket()->isUnpaid()->isInitiale()->get();

        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isSuperMarket()->isInitiale()->find($id);

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
}
