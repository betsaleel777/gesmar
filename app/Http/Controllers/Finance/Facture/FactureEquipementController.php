<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FactureEquipementController extends Controller
{
    public function all(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->isEquipement()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->isPaid()->isEquipement()->get();

        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->isUnpaid()->isEquipement()->get();

        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('contrat.site', 'annexe')->isEquipement()->find($id);

        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Facture::gearRules());
        $facture = new Facture($request->all());
        $facture->facturable();
        $facture->codeGenerate(EQUIPEMENT_FACTURE_PREFIXE);
        $facture->save();
        $message = "La facture d'équipement $facture->code a été crée avec succès.";

        return response()->json(['message' => $message]);
    }
}
