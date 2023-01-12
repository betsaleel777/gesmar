<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Models\Caisse\Encaissement;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use App\Models\Finance\PaiementLigne;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EncaissementController extends Controller
{
    public function all(): JsonResponse
    {
        $encaissements = Encaissement::get();
        return response()->json(['encaissements' => $encaissements]);
    }

    public function store(Request $request): JsonResponse
    {
        if (!empty($request->espece)) {
            $request->validate(array_merge(Encaissement::RULES, Espece::RULES));
            $espece = new Espece($request->all());
            $espece->save();
        }
        if (!empty($request->banque_id)) {
            $request->validate(array_merge(Encaissement::RULES, Cheque::RULES));
        }
        if (!empty($request->paiement_ligne_id)) {
            $request->validate(array_merge(Encaissement::RULES, PaiementLigne::RULES));
        }
        $message = "Encaissement enregistré avec succès.";
        return response()->json(['message' => $message]);
    }
}
