<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Models\Template\TermesContratEmplacement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermesContratsEmplacementsController extends TermesContratsController
{
    public function all(): JsonResponse
    {
        $termes = TermesContratEmplacement::with('site', 'user')->isEmplacement()->get();

        return response()->json(['termes' => $termes]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(TermesContratEmplacement::RULES);
        $terme = new TermesContratEmplacement($request->all());
        $terme->codeGenerate();
        $terme->save();
        $message = "Les termes $terme->code ont été crée avec succès.";

        return response()->json(['message' => $message, 'id' => $terme->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(TermesContratEmplacement::RULES);
        $terme = TermesContratEmplacement::findOrFail($id);
        $terme->update($request->all());
        $message = "Les termes $terme->code ont été modifiés avec succès.";

        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $termes = TermesContratEmplacement::with('site', 'user')->onlyTrashed()->isEmplacement()->get();

        return response()->json(['termes' => $termes]);
    }
}
