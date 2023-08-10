<?php

namespace App\Http\Controllers\Parametre\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\GuichetListResource;
use App\Http\Resources\Caisse\GuichetResource;
use App\Interfaces\StandardControllerInterface;
use App\Models\Caisse\Guichet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GuichetController extends Controller implements StandardControllerInterface
{
    public function all(): JsonResponse
    {
        $guichets = Guichet::get();
        return response()->json(['guichets' => GuichetListResource::collection($guichets)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Guichet::class);
        $request->validate(Guichet::RULES);
        $guichet = new Guichet($request->all());
        $guichet->codeGenerate();
        $guichet->save();
        $guichet->setClose();
        $message = "Le guichet $guichet->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $guichet = Guichet::findOrFail($id);
        $this->authorize('update', $guichet);
        $request->validate(Guichet::RULES);
        $guichet->update($request->all());
        $message = "Le guichet $guichet->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $guichet = Guichet::findOrFail($id);
        $this->authorize('delete', $guichet);
        $guichet->delete();
        $guichet->setClose();
        $message = "Le guichet $guichet->code a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $guichet = Guichet::findOrFail($id);
        $this->authorize('restore', $guichet);
        $guichet->restore();
        $message = "Le guichet $guichet->code a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $this->authorize('viewAny', Guichet::class);
        $guichet = Guichet::withTrashed()->get();
        return response()->json(['guichet' => $guichet]);
    }

    public function show(int $id): JsonResponse
    {
        $guichet = Guichet::find($id);
        $this->authorize('view', $guichet);
        return response()->json(['guichet' => GuichetResource::make($guichet)]);
    }
}
