<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Finance\Commercial;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommercialController extends Controller implements StandardControllerInterface
{
    public function all(): JsonResponse
    {
        $commerciaux = Commercial::all();
        return response()->json(['commerciaux' => $commerciaux]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Commercial::RULES);
        $commercial = new Commercial($request->all());
        $commercial->codeGenerate();
        $commercial->save();
        $message = "Le commercial: $commercial->code a été enregistré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Commercial::RULES);
        $commercial = Commercial::find($id);
        $commercial->update($request->all());
        $message = "Le commercial: $commercial->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $commercial = Commercial::findOrFail($id);
        $commercial->delete();
        $message = "Le commercial: $commercial->code a été supprimé avec succès.";
        // TODO: lorsque le commercial est supprimé il faut attribuer forcement ces bordereaux à une autre sinon on empêche la suppression
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $commercial = Commercial::withTrashed()->find($id);
        $commercial->restore();
        $message = "Le commercial $commercial->code a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $commerciaux = Commercial::onlyTrashed()->get();
        return response()->json(['commerciaux' => $commerciaux]);
    }

    public function show(int $id): JsonResponse
    {
        $commerciaux = Commercial::withTrashed()->get();
        return response()->json(['commerciaux' => $commerciaux]);
    }
}
