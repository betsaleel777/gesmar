<?php

namespace App\Http\Controllers\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\BanqueResource;
use App\Models\Caisse\Banque;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BanqueController extends Controller
{
    public function all(): JsonResponse
    {
        $banques = Banque::get();
        return response()->json(['banques' => BanqueResource::collection($banques)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Banque::RULES);
        $banque = new Banque($request->all());
        $banque->save();
        $message = "La banque: $banque->sigle a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function show(int $id): JsonResponse
    {
        $banque = Banque::findOrFail($id);
        return response()->json(['banque' => $banque]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Banque::RULES);
        $banque = Banque::findOrFail($id);
        $banque->update($request->all());
        $message = 'La banque a été modifié avec succès.';
        return response()->json(['message' => $message]);
    }
}
