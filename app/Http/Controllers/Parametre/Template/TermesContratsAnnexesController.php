<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Models\Template\TermesContratAnnexe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermesContratsAnnexesController extends TermesContratsController
{
    public function all(): JsonResponse
    {
        $this->authorize('viewAny', TermesContratAnnexe::class);
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'type', 'created_at')
            ->with('site', 'user')->get();
        return response()->json(['termes' => $termes]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', TermesContratAnnexe::class);
        $request->validate(TermesContratAnnexe::RULES);
        $terme = new TermesContratAnnexe($request->all());
        $terme->codeGenerate();
        $terme->save();
        $message = "Les termes $terme->code ont été crées avec succès.";
        return response()->json(['message' => $message, 'id' => $terme->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $terme = TermesContratAnnexe::findOrFail($id);
        $this->authorize('create', $terme);
        $request->validate(TermesContratAnnexe::RULES);
        $terme->update($request->all());
        $message = "Les termes $terme->code ont été modifiés avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $this->authorize('viewAny', TermesContratAnnexe::class);
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'type', 'created_at')
            ->with('site', 'user')->onlyTrashed()->get();
        return response()->json(['termes' => $termes]);
    }

    public function pdf(int $id)
    {
        $terme = TermesContratAnnexe::findOrFail($id);
        return response()->json(['path' => $terme->getFirstMedia(COLLECTION_MEDIA_CONTRAT_ANNEXE)->getUrl()]);
    }
}
