<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\ServiceAnnexe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ServiceAnnexesController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', ServiceAnnexe::class);
        if ($response->allowed()) {
            $annexes = ServiceAnnexe::with('site')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $annexes = ServiceAnnexe::with('site')->inside($sites)->get();
        }
        return response()->json(['annexes' => $annexes]);
    }

    public function show(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::with('site')->findOrFail($id);
        return response()->json(['annexe' => $annexe]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(ServiceAnnexe::RULES);
        $annexe = new ServiceAnnexe($request->all());
        $annexe->codeGenerate();
        $annexe->save();
        $message = "Le service annexe $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(ServiceAnnexe::RULES);
        $annexe = ServiceAnnexe::findOrFail($id);
        $annexe->update($request->all());
        $annexe->save();
        $message = "Le service annexe $request->nom a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::withTrashed()->find($id);
        $annexe->restore();
        $message = "Le service annexe $annexe->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', ServiceAnnexe::class);
        if ($response->allowed()) {
            $annexes = ServiceAnnexe::with('site')->onlyTrashed()->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $annexes = ServiceAnnexe::with('site')->inside($sites)->onlyTrashed()->get();
        }
        return response()->json(['annexes' => $annexes]);
    }

    public function trash(int $id): JsonResponse
    {
        $annexe = ServiceAnnexe::findOrFail($id);
        $annexe->delete();
        $message = "Le service annexe $annexe->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $annexes = ServiceAnnexe::with('site')->where('site_id', $id)->get();
        return response()->json(['annexes' => $annexes]);
    }
}
