<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\Request;

class FactureInitialeController extends Controller
{
    public function all()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isInitiale()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->validees()->isInitiale()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->nonValidees()->isInitiale()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id)
    {
        $facture = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isInitiale()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request)
    {
        $request->validate(Facture::initialeRules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(INITIALE_PREFIXE);
        $facture->save();
        $message = "La facture initiale: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
