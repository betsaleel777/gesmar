<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Events\TermeContratBailPrepare;
use App\Events\TermeContratBailRegistred;
use App\Models\Template\TermesContratEmplacement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermesContratsEmplacementsController extends TermesContratsController
{
    public function all(): JsonResponse
    {
        $this->authorize('viewAny', TermesContratEmplacement::class);
        $termes = TermesContratEmplacement::with(['site', 'user'])->get();
        return response()->json(['termes' => $termes]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', TermesContratEmplacement::class);
        $request->validate(TermesContratEmplacement::RULES);
        TermeContratBailPrepare::dispatch();
        $terme = new TermesContratEmplacement($request->all());
        $terme->codeGenerate();
        $terme->save();
        TermeContratBailRegistred::dispatch($terme);
        $message = "Les termes $terme->code ont été crée avec succès.";
        return response()->json(['message' => $message, 'id' => $terme->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $terme = TermesContratEmplacement::findOrFail($id);
        $this->authorize('update', $terme);
        $request->validate(TermesContratEmplacement::RULES);
        $terme->update($request->all());
        $message = "Les termes $terme->code ont été modifiés avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $this->authorize('viewAny', TermesContratEmplacement::class);
        $termes = TermesContratEmplacement::with(['site', 'user'])->onlyTrashed()->get();
        return response()->json(['termes' => $termes]);
    }

    public function pdf(int $id)
    {
        $terme = TermesContratEmplacement::findOrFail($id);
        return response()->json(['path' => $terme->getFirstMedia(config('constants.COLLECTION_MEDIA_CONTRAT_BAIL'))->getUrl()]);
    }
}
