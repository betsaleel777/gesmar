<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\BanqueResource;
use App\Models\Caisse\Banque;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BanqueController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Banque::class);
        $banques = $response->allowed() ? Banque::with('site')->get() : Banque::with('site')->owner()->get();
        return response()->json(['banques' => BanqueResource::collection($banques)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Banque::class);
        $request->validate(Banque::RULES);
        $banque = new Banque($request->all());
        $banque->save();
        return response()->json(['message' => "La banque: $banque->sigle a été enregistré avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $banque = Banque::find($id);
        $this->authorize('update', $banque);
        $request->validate(Banque::RULES);
        $banque->update($request->all());
        return response()->json(['message' => 'La banque a été modifié avec succès.']);
    }
}
