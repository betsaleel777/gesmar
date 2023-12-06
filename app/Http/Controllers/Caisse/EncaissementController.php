<?php

namespace App\Http\Controllers\Caisse;

use App\Events\EncaissementRegistred;
use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\EncaissementListeResource;
use App\Http\Resources\Caisse\EncaissementResource;
use App\Models\Caisse\Encaissement;
use App\Models\Caisse\Ouverture;
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
        $ouverture = Ouverture::using()->where('caissier_id', $request->caissier_id)->first();
        $encaissement->ouverture_id = $ouverture->id;
        $espece = Espece::findOrFail($espece->id);
        $encaissement->payable()->associate($espece);
        $encaissement->save();
        EncaissementRegistred::dispatch($encaissement);
    }

    private static function storePayableCheque(Request $request): void
    {
        $request->validate(array_merge(Encaissement::RULES, Cheque::RULES));
        $cheque = new Cheque($request->all());
        $cheque->save();
        $encaissement = new Encaissement($request->all());
        $ouverture = Ouverture::using()->where('caissier_id', $request->caissier_id)->first();
        $encaissement->ouverture_id = $ouverture->id;
        $cheque = Cheque::findOrFail($cheque->id);
        $encaissement->payable()->associate($cheque);
        $encaissement->save();
        EncaissementRegistred::dispatch($encaissement);
    }

    public function all(): JsonResponse
    {
        $encaissements = Encaissement::with('payable', 'caissier:id,user_id', 'caissier.user:id,name', 'ordonnancement:id,code',
            'bordereau:id,code')->opened()->get();
        return response()->json(['encaissements' => EncaissementListeResource::collection($encaissements)]);
    }

    public function show(int $id): JsonResponse
    {
        $encaissement = Encaissement::with('payable', 'caissier:id,user_id', 'caissier.user:id,name', 'ordonnancement:id,total,code',
            'ordonnancement.emplacement:emplacements.id,emplacements.code', 'ordonnancement.personne:personnes.id,personnes.nom', 'ouverture:id,guichet_id', 'ouverture.guichet:id,nom', 'bordereau:id,code')->find($id);
        return response()->json(['encaissement' => EncaissementResource::make($encaissement)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->mode === 1 ? self::storePayableEspece($request) : self::storePayableCheque($request);
        $message = "Encaissement enregistré avec succès.";
        return response()->json(['message' => $message]);
    }
}
