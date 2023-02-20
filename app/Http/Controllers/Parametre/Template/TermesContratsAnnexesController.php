<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Models\Template\TermesContratAnnexe;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermesContratsAnnexesController extends TermesContratsController
{
    public function all(): JsonResponse
    {
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'date_using', 'type', 'created_at')
            ->with('site', 'user')->isAnnexe()->get();
        return response()->json(['termes' => $termes]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(TermesContratAnnexe::RULES);
        $terme = new TermesContratAnnexe($request->all());
        $terme->codeGenerate();
        $terme->save();
        $message = "Les termes $terme->code ont été crées avec succès.";
        return response()->json(['message' => $message, 'id' => $terme->id]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(TermesContratAnnexe::RULES);
        $terme = TermesContratAnnexe::findOrFail($id);
        $terme->update($request->all());
        $message = "Les termes $terme->code ont été modifiés avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'date_using', 'type', 'created_at')
            ->with('site', 'user')->onlyTrashed()->isAnnexe()->get();
        return response()->json(['termes' => $termes]);
    }

    public function pdf(int $id)
    {
        $terme = TermesContratAnnexe::with(['site', 'user'])->findOrFail($id);
        $filename = 'exampleContratAnnexe.pdf';
        $html = $terme->contenu;
        TCPDF::SetTitle('Example de Contrat');
        TCPDF::setCellHeightRatio(0.7);
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');
        $pathStorage = public_path() . '/storage/user-' . $terme->user->id . '/' . $filename;
        $pathDisplay = 'user-' . $terme->user->id . '/' . $filename;
        TCPDF::Output($pathStorage, 'F');
        return response()->json(['path' => $pathDisplay]);
    }
}
