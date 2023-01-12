<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Finance\PaiementLigne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaiementLigneController extends Controller
{
    public function all(): JsonResponse
    {
        $paiements = PaiementLigne::get();
        return response()->json(['cheques' => $paiements]);
    }

    public function store(Request $request): void
    {
        $paiement = new PaiementLigne($request->all());
        $paiement->save();
    }

    public function show(int $id): JsonResponse
    {
        $paiement = PaiementLigne::find($id);
        return response()->json(['cheque' => $paiement]);
    }
}
