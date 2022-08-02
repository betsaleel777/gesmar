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
        $factures = Facture::with('contrat.personne', 'contrat.site')->validees()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->nonValidees()->get();

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
}
