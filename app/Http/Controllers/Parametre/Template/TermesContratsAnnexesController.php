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

    public function pdf(int $id): JsonResponse
    {
        $terme = TermesContratAnnexe::with('site', 'user')->findOrFail($id);
        $filename = 'exampleContrat.pdf';
        $html = $terme->contenu;
        $pdf = new TCPDF;
        $pdf::SetTitle('Example de Contrat');
        $pdf::setCellHeightRatio(0.7);
        $pdf::AddPage();
        $pdf::writeHTML($html, true, false, true, false, '');
        $pdf::Output(public_path($filename), 'F');

        return response()->json(['pdf' => public_path($filename)]);
    }
}
