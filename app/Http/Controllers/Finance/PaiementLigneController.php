<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\PaiementLigne;
use Illuminate\Http\Request;

class PaiementLigneController extends Controller
{
    public function all()
    {
        $paiements = PaiementLigne::with('site')->get();
        return response()->json(['cheques' => $paiements]);
    }

    public function store(Request $request)
    {
        $paiement = new PaiementLigne($request->all());
        $paiement->save();
    }

    public function show(int $id)
    {
        $paiement = PaiementLigne::with('site')->find($id);
        return response()->json(['cheque' => $paiement]);
    }
}
