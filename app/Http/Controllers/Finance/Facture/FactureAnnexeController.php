<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Models\Finance\Facture;
use Illuminate\Http\Request;

class FactureAnnexeController extends FactureController
{
    public function all()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->validees()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site', 'annexe')->nonValidees()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id)
    {
        $facture = Facture::with('contrat.personne', 'contrat.site', 'annexe')->isAnnexe()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request)
    {
        $request->validate(Facture::RULES);
        $facture = new Facture($request->all());
        $facture->codeGenerate(ANNEXE_PREFIXE);
        $facture->save();
        $message = "La facture annexe: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
