<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureLoyerController extends Controller
{
    const RELATIONS = ['contrat.site', 'contrat.emplacement', 'contrat.personne'];

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
        foreach ($request->all() as $data) {
            $facture = new Facture($data);
            $facture->codeGenerate(LOYER_FACTURE_PREFIXE);
            $facture->save();
            $facture->facturable();
        }
        $message = "Factures générées avec succès.";
        return response()->json(['message' => $message]);
    }
}
