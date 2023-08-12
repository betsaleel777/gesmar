<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\TypeEquipementListResource;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\TypeEquipement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TypeEquipementsController extends Controller implements StandardControllerInterface
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', TypeEquipement::class);
        if ($response->allowed()) {
            $types = TypeEquipement::with('site')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $types = TypeEquipement::with('site')->inside($sites)->get();
        }
        return response()->json(['types' => TypeEquipementListResource::collection($types)]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(TypeEquipement::RULES);
        $type = new TypeEquipement($request->all());
        $type->save();
        $message = "Le type d'équipement $request->nom a été enrgistré avec succès.";
        return response()->json(['message' => $message, 'id' => $type->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(TypeEquipement::RULES);
        $type = TypeEquipement::findOrFail($id);
        $type->update($request->all());
        $message = "Type d'équipement a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $type = TypeEquipement::findOrFail($id);
        $type->delete();
        $message = "Le type d'équipement: $type->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $type = TypeEquipement::withTrashed()->find($id);
        $type->restore();
        $message = "Le type d'équipement $type->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', TypeEquipement::class);
        if ($response->allowed()) {
            $types = TypeEquipement::with('site')->onlyTrashed()->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $types = TypeEquipement::with('site')->inside($sites)->onlyTrashed()->get();
        }
        return response()->json(['types' => $types]);
    }

    public function show(int $id): JsonResponse
    {
        $type = TypeEquipement::with('site')->withTrashed()->find($id);
        return response()->json(['type' => $type]);
    }
}
