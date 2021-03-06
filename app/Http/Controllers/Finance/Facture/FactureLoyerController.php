<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\Request;

class FactureLoyerController extends Controller
{
    public function all()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->validees()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->nonValidees()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id)
    {
        $facture = Facture::with('contrat.site', 'contrat.emplacement', 'contrat.personne')->isLoyer()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request)
    {
        $request->validate(Facture::loyerRules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(LOYER_PREFIXE);
        $facture->save();
        $message = "La facture de loyer: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
