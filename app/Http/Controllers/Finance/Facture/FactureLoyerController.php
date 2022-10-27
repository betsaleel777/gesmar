<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureLoyerController extends Controller
{
    const RELATIONS = [self::RELATIONS];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isLoyer()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Facture::loyerRules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(LOYER_FACTURE_PREFIXE);
        $facture->facturable();
        $facture->save();
        $message = "La facture de loyer: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
