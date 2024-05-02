<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\CaissierListResouce;
use App\Http\Resources\Caisse\CaissierResource;
use App\Models\Caisse\Caissier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CaissierController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Caissier::class);
        $query = Caissier::with('user:id,name');
        $caissiers = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['caissiers' => CaissierListResouce::collection($caissiers)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Caissier::class);
        $request->validate(Caissier::RULES);
        $caissier = new Caissier($request->all());
        $caissier->codeGenerate();
        $caissier->save();
        return response()->json(['message' => "Le caissier: $caissier->code a été enregistré avec succès."]);
    }

    public function trash(int $id): JsonResponse
    {
        $caissier = Caissier::with('user:id,name')->find($id);
        $this->authorize('delete', $caissier);
        $caissier->delete();
        return response()->json(['message' => "Le caissier: $caissier->code a été supprimé avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        $caissier = Caissier::with('attributionsGuichet', 'user:id,name')->find($id);
        $this->authorize('view', $caissier);
        return response()->json(['caissier' => CaissierResource::make($caissier)]);
    }

    public function attribuate(Request $request): JsonResponse
    {
        $caissier = Caissier::findOrFail($request->caissier_id);
        $this->authorize('attribuate', $caissier);
        $request->validate(Caissier::ATTRIBUTION_RULES);
        foreach ($request->dates as $dates) {
            $caissier->attributionsGuichet()->attach($request->guichet_id, ['date' => $dates]);
        }
        return response()->json(['message' => "Guichet attribué avec succès."]);
    }

    // à revoir en utilisant id du caissier
    public function desattribuate(int $id): JsonResponse
    {
        // $caissier = Caissier::find($id);
        // $this->authorize('attribuate', $caissier);
        DB::table('attribution_guichets')->delete($id);
        return response()->json(['message' => "Cette attribution de guichet a bien été modifiée."]);
    }
}
