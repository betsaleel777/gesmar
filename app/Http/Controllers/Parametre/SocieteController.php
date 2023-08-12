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
        $this->authorize('create', Societe::class);
        $request->validate(Societe::RULES);
        $societe = Societe::make($request->all());
        $societe->save();
        $societe->addMediaFromRequest('logo')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        return response()->json(['message' => "La société $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request)
    {
        $societe = Societe::findOrFail($id);
        $this->authorize('update', $societe);
        $request->validate(Societe::EDIT_RULES);
        $societe->update($request->all());
        if ($request->hasFile('logo')) {
            $societe->addMediaFromRequest('logo')->toMediaCollection(COLLECTION_MEDIA_LOGO);
        }
        return response()->json(['message' => "La société a été modifiée avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        $societe = Societe::find($id);
        $this->authorize('view', $societe);
        return response()->json(['societe' => SocieteResource::make($societe)]);
    }
}
