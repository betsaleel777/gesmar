<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\TypeEquipementListResource;
use App\Models\Architecture\TypeEquipement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TypeEquipementsController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', TypeEquipement::class);
        $query = TypeEquipement::with('site');
        $types = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['types' => TypeEquipementListResource::collection($types)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', TypeEquipement::class);
        $request->validate(TypeEquipement::RULES);
        $type = new TypeEquipement($request->all());
        $type->save();
        return response()->json(['message' => "Le type d'équipement $request->nom a été enrgistré avec succès.", 'id' => $type->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $type = TypeEquipement::find($id);
        $this->authorize('update', $type);
        $request->validate(TypeEquipement::RULES);
        $type->update($request->all());
        return response()->json(['message' => "Type d'équipement a été modifié avec succès."]);
    }

    public function trash(int $id): JsonResponse
    {
        $type = TypeEquipement::findOrFail($id);
        $this->authorize('delete', $type);
        $type->delete();
        return response()->json(['message' => "Le type d'équipement: $type->nom a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $type = TypeEquipement::withTrashed()->find($id);
        $this->authorize('restore', $type);
        $type->restore();
        return response()->json(['message' => "Le type d'équipement $type->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', TypeEquipement::class);
        $query = TypeEquipement::with('site');
        $types = $response->allowed() ? $query->get() : $query->owner()->onlyTrashed()->get();
        return response()->json(['types' => $types]);
    }

    public function show(int $id): JsonResponse
    {
        $type = TypeEquipement::with('site')->withTrashed()->find($id);
        $this->authorize('update', $type);
        return response()->json(['type' => $type]);
    }
}
