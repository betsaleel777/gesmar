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
        $societe = Societe::first();
        $retour = empty($societe) ?: SocieteResource::make($societe);
        return response()->json(['societe' => $retour]);
    }

    public function store(Request $request)
    {
        $request->validate(Societe::RULES);
        $societe = Societe::make($request->all());
        $societe->save();
        $societe->addMediaFromRequest('logo')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        return response()->json(['message' => "La société $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Societe::EDIT_RULES);
        $societe = Societe::findOrFail($id);
        $societe->update($request->all());
        if ($request->hasFile('logo')) {
            $societe->addMediaFromRequest('logo')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        }
        return response()->json(['message' => "La société a été modifiée avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(['societe' => SocieteResource::make(Societe::find($id))]);
    }
}
