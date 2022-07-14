<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture\Facture;

class FactureController extends Controller
{
    public function all()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->validees()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees()
    {
        $factures = Facture::with('contrat.personne', 'contrat.site')->nonValidees()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id)
    {
        $facture = Facture::with('contrat.personne', 'contrat.site')->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function valider(int $id)
    {
        $facture = Facture::find($id);
        $facture->valider();
        $message = "La facture $facture->code a été validée avec succès.";
        return response()->json(['message' => $message]);
    }

}
