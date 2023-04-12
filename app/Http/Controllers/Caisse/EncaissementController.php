<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\EncaissementListeResource;
use App\Models\Caisse\Encaissement;
use App\Models\Finance\Cheque;
use App\Models\Finance\Espece;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EncaissementController extends Controller
{
    private static function storePayableEspece(Request $request): void
    {
        $request->validate(array_merge(Encaissement::RULES, Espece::RULES));
        $espece = new Espece($request->all());
        $espece->save();
        $encaissement = new Encaissement($request->all());
        $espece = Espece::findOrFail($espece->id);
        $encaissement->payable()->associate($espece);
        $encaissement->save();
    }

    private static function storePayableCheque(Request $request): void
    {
        $request->validate(array_merge(Encaissement::RULES, Cheque::RULES));
        $cheque = new Cheque($request->all());
        $cheque->save();
        $encaissement = new Encaissement($request->all());
        $cheque = Cheque::findOrFail($cheque->id);
        $encaissement->payable()->associate($cheque);
        $encaissement->save();
    }

    public function all(): JsonResponse
    {
        $encaissements = Encaissement::with('payable', 'caissier', 'ordonnancement')->get();
        return response()->json(['encaissements' => EncaissementListeResource::collection($encaissements)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->mode === 1 ? self::storePayableEspece($request) : self::storePayableCheque($request);
        $message = "Encaissement enregistré avec succès.";
        return response()->json(['message' => $message]);
    }
}
