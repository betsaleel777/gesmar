<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureEquipementController extends Controller
{
    const RELATIONS = ['contrat.site', 'contrat' => ['emplacement', 'personne'], 'equipement'];
    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isEquipement()->isFacture()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(['contrat.site', 'annexe'])->isEquipement()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        foreach ($request->all() as $ligne) {
            $facture = new Facture($ligne);
            $facture->codeGenerate(EQUIPEMENT_FACTURE_PREFIXE);
            $facture->save();
            $facture->facturable();
        }
        $message = "La facture d'équipement $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
