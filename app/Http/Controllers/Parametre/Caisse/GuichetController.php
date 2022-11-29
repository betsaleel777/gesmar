<?php

namespace App\Http\Controllers\Parametre\Caisse;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Caisse\Guichet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GuichetController extends Controller implements StandardControllerInterface
{
    public function all(): JsonResponse
    {
        $guichets = Guichet::get();
        return response()->json(['guichets' => $guichets]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Guichet::RULES);
        $guichet = new Guichet($request->all());
        $guichet->codeGenerate();
        $guichet->save();
        $guichet->close();
        $message = "Le guichet $guichet->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Guichet::RULES);
        $guichet = Guichet::findOrFail($id);
        $guichet->update($request->all());
        $message = "Le guichet $guichet->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $guichet = Guichet::findOrFail($id);
        $guichet->delete();
        $guichet->close();
        $message = "Le guichet $guichet->code a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $guichet = Guichet::findOrFail($id);
        $guichet->restore();
        $message = "Le guichet $guichet->code a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $guichet = Guichet::withTrashed()->get();
        return response()->json(['guichet' => $guichet]);
    }

    public function show(int $id): JsonResponse
    {
        $guichet = Guichet::findOrFail($id)->withTrashed();
        return response()->json(['guichet' => $guichet]);
    }
}
