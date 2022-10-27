<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Http\Controllers\Controller;
use App\Models\Template\TermesContrat;
use Illuminate\Http\JsonResponse;

class TermesContratsController extends Controller
{
    public function all(): JsonResponse
    {
        $termes = TermesContrat::with(['site', 'user'])->get();

        return response()->json(['termes' => $termes]);
    }

    public function trash(int $id): JsonResponse
    {
        $terme = TermesContrat::findOrFail($id);
        $terme->delete();
        $message = "Les termes $terme->code ont été supprimés avec succès.";

        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $terme = TermesContrat::withTrashed()->find($id);
        $terme->restore();
        $message = "Les termes $terme->code ont été restaurés avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $termes = TermesContrat::with(['site', 'user'])->onlyTrashed()->get();

        return response()->json(['termes' => $termes]);
    }

    public function show(int $id): JsonResponse
    {
        $terme = TermesContrat::with(['site', 'user'])->withTrashed()->find($id);

        return response()->json(['terme' => $terme]);
    }
}
