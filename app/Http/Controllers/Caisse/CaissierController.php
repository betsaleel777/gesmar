<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\CaissierListResouce;
use App\Http\Resources\Caisse\CaissierResource;
use App\Models\Caisse\Caissier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaissierController extends Controller
{
    public function all(): JsonResponse
    {
        $caissiers = Caissier::with('user:id,name')->get();
        return response()->json(['caissiers' => CaissierListResouce::collection($caissiers)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Caissier::class);
        $request->validate(Caissier::RULES);
        $caissier = new Caissier($request->all());
        $caissier->codeGenerate();
        $caissier->save();
        $message = "Le caissier: $caissier->code a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $caissier = Caissier::with('user:id,name')->find($id);
        $this->authorize('delete', $caissier);
        $caissier->delete();
        $message = "Le caissier: $caissier->code a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $caissier = Caissier::with('attributionsGuichet', 'user:id,name')->findOrFail($id);
        $this->authorize('view', $caissier);
        return response()->json(['caissier' => CaissierResource::make($caissier)]);
    }

    public function attribuate(Request $request): JsonResponse
    {
        $caissier = Caissier::findOrFail($request->caissier_id);
        $this->authorize('view', $caissier);
        $request->validate(Caissier::ATTRIBUTION_RULES);
        foreach ($request->dates as $dates) {
            $caissier->attributionsGuichet()->attach($request->guichet_id, ['date' => $dates]);
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
