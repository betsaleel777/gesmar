<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Emplacement\TypeEmplacementListResource;
use App\Http\Resources\Emplacement\TypeEmplacementResource;
use App\Models\Architecture\TypeEmplacement as Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TypeEmplacementsController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Type::class);
        $query = Type::with('site:id,nom');
        $types = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['types' => TypeEmplacementListResource::collection($types)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Type::class);
        $request->validate(Type::RULES);
        $type = new Type($request->all());
        $type->save();
        return response()->json(['message' => "Le type d'emplacement $request->nom a été crée avec succès.", 'id' => $type->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $type = Type::find($id);
        $this->authorize('update', $type);
        $request->validate(Type::RULES);
        $type->update($request->all());
        return response()->json(['message' => "Le type d'emplacement $request->nom a été modifié avec succès."]);
    }

    public function push(Request $request): JsonResponse
    {
        $this->authorize('create', Type::class);
        $request->validate(Type::RULES);
        $type = new Type($request->all());
        $type->save();
        $freshMarche = $type->fresh();
        return response()->json(['message' => "Le type d'emplacement $request->nom a été crée avec succès.", 'marche' => $freshMarche]);
    }

    public function trash(int $id): JsonResponse
    {
        $this->authorize('delete', Type::class);
        $type = Type::findOrFail($id);
        $type->delete();
        return response()->json(['message' => "Le type d'emplacement $type->nom a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $type = Type::withTrashed()->find($id);
        $this->authorize('restore', $type);
        $type->restore();
        return response()->json(['message' => "Le type d'emplacement $type->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Type::class);
        $query = Type::with('site:id,nom')->onlyTrashed();
        $types = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['types' => $types]);
    }

    public function show(int $id): JsonResponse
    {
        $type = Type::with('site:id,nom')->find($id);
        $this->authorize('update', $type);
        return response()->json(['type' => TypeEmplacementResource::make($type)]);
    }
}
