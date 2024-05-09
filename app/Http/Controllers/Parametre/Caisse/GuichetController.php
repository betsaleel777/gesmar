<?php

namespace App\Http\Controllers\Parametre\Caisse;

use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\GuichetListResource;
use App\Http\Resources\Caisse\GuichetResource;
use App\Interfaces\StandardControllerInterface;
use App\Models\Caisse\Guichet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GuichetController extends Controller implements StandardControllerInterface
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Guichet::class);
        $guichets = $response->allowed() ? Guichet::get() : Guichet::owner()->get();
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
        return response()->json(['message' => "Le guichet $guichet->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $guichet = Guichet::find($id);
        $this->authorize('update', $guichet);
        $request->validate(Guichet::RULES);
        $guichet->update($request->all());
        return response()->json(['message' => "Le guichet $guichet->code a été modifié avec succès."]);
    }

    public function trash(int $id): JsonResponse
    {
        $guichet = Guichet::find($id);
        $this->authorize('delete', $guichet);
        $guichet->delete();
        $guichet->setClose();
        return response()->json(['message' => "Le guichet $guichet->code a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $guichet = Guichet::find($id);
        $this->authorize('restore', $guichet);
        $guichet->restore();
        return response()->json(['message' => "Le guichet $guichet->code a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Guichet::class);
        $guichets = $response->allowed() ? Guichet::onlyTrashed()->get() : Guichet::onlyTrashed()->owner()->get();
        return response()->json(['guichets' => $guichets]);
    }

    public function show(int $id): JsonResponse
    {
        $guichet = Guichet::find($id);
        $this->authorize('view', $guichet);
        return response()->json(['guichet' => GuichetResource::make($guichet)]);
    }
}
