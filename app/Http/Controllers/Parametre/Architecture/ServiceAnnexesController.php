<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\ServiceAnnexe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceAnnexesController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', ServiceAnnexe::class);
        $annexes = $response->allowed() ? ServiceAnnexe::with('site')->get() : ServiceAnnexe::with('site')->owner()->get();
        return response()->json(['annexes' => $annexes]);
    }

    public function show(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::with('site')->findOrFail($id);
        $this->authorize('view', $annexe);
        return response()->json(['annexe' => $annexe]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', ServiceAnnexe::class);
        $request->validate(ServiceAnnexe::RULES);
        $annexe = new ServiceAnnexe($request->all());
        $annexe->codeGenerate();
        $annexe->save();
        return response()->json(['message' => "Le service annexe $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $annexe = ServiceAnnexe::findOrFail($id);
        $this->authorize('update', $annexe);
        $request->validate(ServiceAnnexe::RULES);
        $annexe->update($request->all());
        $annexe->save();
        return response()->json(['message' => "Le service annexe $request->nom a été modifié avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::withTrashed()->find($id);
        $annexe->restore();
        return response()->json(['message' => "Le service annexe $annexe->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', ServiceAnnexe::class);
        $query = ServiceAnnexe::with('site')->onlyTrashed();
        $annexes = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['annexes' => $annexes]);
    }

    public function trash(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::findOrFail($id);
        $this->authorize('delete', $annexe);
        $annexe->delete();
        return response()->json(['message' => "Le service annexe $annexe->nom a été supprimé avec succès."]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', ServiceAnnexe::class);
        $query = ServiceAnnexe::with('site')->where('site_id', $id);
        $annexes = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['annexes' => $annexes]);
    }
}
