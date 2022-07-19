<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Models\Finance\Facture;
use Illuminate\Http\Request;

class FactureEquipementController extends Controller
{

    public function all()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->validees()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees()
    {
        $factures = Facture::with('contrat.site', 'contrat.emplacement', 'equipement')->nonValidees()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id)
    {
        $facture = Facture::with('contrat.site', 'annexe')->isEquipement()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request)
    {
        $request->validate(Facture::rules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(EQUIPEMENT_PREFIXE);
        $facture->save();
        $message = "La facture d'équipement $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
