<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Models\Template\TermesContratEmplacement;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermesContratsEmplacementsController extends TermesContratsController
{
    public function all(): JsonResponse
    {
        $termes = TermesContratEmplacement::with(['site', 'user'])->isEmplacement()->get();
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
        $termes = TermesContratEmplacement::with(['site', 'user'])->onlyTrashed()->isEmplacement()->get();
        return response()->json(['termes' => $termes]);
    }

    public function pdf(int $id)
    {
        $terme = TermesContratEmplacement::with(['site', 'user'])->findOrFail($id);
        $filename = 'exampleContratBail.pdf';
        $html = $terme->contenu;
        TCPDF::SetTitle('Example de Contrat');
        TCPDF::setCellHeightRatio(1.10);
        TCPDF::AddPage();
        TCPDF::writeHTML($html, true, false, true, false, '');
        $pathStorage = public_path() . '/storage/user-' . $terme->user->id . '/' . $filename;
        $pathDisplay = 'user-' . $terme->user->id . '/' . $filename;
        TCPDF::Output($pathStorage, 'F');
        return response()->json(['path' => $pathDisplay]);
    }
}
