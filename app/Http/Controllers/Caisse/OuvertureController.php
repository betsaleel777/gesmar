<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\OuvertureListResource;
use App\Http\Resources\Caisse\OuvertureResource;
use App\Models\Caisse\Ouverture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OuvertureController extends Controller
{
    public function all(): JsonResponse
    {
        $ouvertures = Ouverture::get();
        return response()->json(['ouvertures' => OuvertureListResource::collection($ouvertures)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Ouverture::RULES);
        $ouverture = new Ouverture($request->all());
        $ouverture->codeGenerate();
        $ouverture->save();
        $ouverture->setUsing();
        $message = "L'ouverture $ouverture->code a été crée avec succès";
        return response()->json(['message' => $message]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $ouvertures = Ouverture::whereHas(
            'site',
            fn (Builder $query) =>
            $query->where('id', $id)
        )->get();
        return response()->json(['ouverture' => $ouvertures]);
    }

    public function show(int $id): JsonResponse
    {
        $ouverture = Ouverture::findOrFail($id);
        return response()->json(['ouverture' => $ouverture]);
    }

    public function exists(int $id): JsonResponse
    {
        $exists = Ouverture::where('caissier_id', $id)->where('date', date('Y-m-d'))->exists();
        return response()->json(['exists' => $exists]);
    }

    public function getCurrentByCaissier(int $id): JsonResponse
    {
        $ouverture = Ouverture::with('encaissements.ordonnancement')->where('caissier_id', $id)->using()->first();
        return empty($ouverture) ? response()->json(['message' => "il n'y a aucune caisse ouverte actuellement pour cet utilisateur"])
            : response()->json(['ouverture' => OuvertureResource::make($ouverture)]);
    }

    public function getUsingByCaissier(int $id)
    {
        $exists = Ouverture::where('caissier_id', $id)->using()->exists();
        return response()->json(['exists' => $exists]);
    }
}
