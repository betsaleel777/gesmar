<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\CompteResource;
use App\Models\Caisse\Compte;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompteController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Compte::class);
        $comptes = $response->allowed() ? Compte::get() : Compte::owner()->get();
        return response()->json(['comptes' => CompteResource::collection($comptes)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Compte::class);
        $request->validate(Compte::RULES);
        $compte = new Compte($request->all());
        $compte->save();
        return response()->json(['message' => "Le compte: $compte->code a été enregistré avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        $compte = Compte::findOrFail($id);
        $this->authorize('view', $compte);
        return response()->json(['compte' => $compte]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $compte = Compte::findOrFail($id);
        $this->authorize('update', $compte);
        $request->validate(Compte::RULES);
        $compte->update($request->all());
        return response()->json(['message' => 'Le compte a été modifié avec succès.']);
    }
}
