<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\CaissierListResouce;
use App\Models\Caisse\Caissier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaissierController extends Controller
{
    public function all(): JsonResponse
    {
        $caissiers = Caissier::get();
        return response()->json(['caissiers' => CaissierListResouce::collection($caissiers)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Caissier::RULES);
        $caissier = new Caissier($request->all());
        $caissier->codeGenerate();
        $caissier->save();
        $message = "Le caissier: $caissier->code a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $caissier = Caissier::findOrFail($id);
        $caissier->delete();
        $message = "Le caissier: $caissier->code a été supprimé avec succès.";
        // TODO: lorsque le caissier est supprimé il faut attribuer forcement ces bordereaux à une autre sinon on empêche la suppression
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $caissier = Caissier::with('attributions')->findOrFail($id);
        return response()->json(['caissier' => $caissier]);
    }

    public function attribuate(Request $request): JsonResponse
    {
        $request->validate(Caissier::ATTRIBUTION_RULES);
        $caissier = Caissier::findOrFail($request->caissier_id);
        foreach ($request->dates as $dates) {
            $caissier->attributions()->attach($request->guichet_id, ['date' => $dates]);
        }
        $message = "Guichet attribué avec succès.";
        return response()->json(['message' => $message]);
    }

    public function desattribuate(int $id): JsonResponse
    {
        DB::table('attribution_guichets')->delete($id);
        $message = "Cette attribution de guichet a bien été modifiée.";
        return response()->json(['message' => $message]);
    }
}
