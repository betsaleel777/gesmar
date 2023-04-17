<?php

namespace App\Http\Controllers\Parametre;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocieteResource;
use App\Models\Societe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocieteController extends Controller
{
    public function all(): JsonResponse
    {
        return response()->json(['societes' => SocieteResource::collection(Societe::all())]);
    }

    public function store(Request $request)
    {
        $request->validate(Societe::RULES);
        $societe = new Societe($request->all());
        $societe->save();
        $societe->addMediaFromRequest('logo')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        return response()->json(['message' => "La société $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Societe::editRules($id));
        $societe = Societe::findOrFail($id);
        $societe->update($request->all());
        $societe->addMediaFromRequest('image')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        return response()->json(['message' => "La société a été modifiée avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(['societe' => SocieteResource::make(Societe::find($id))]);
    }
}
