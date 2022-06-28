<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Models\Template\TermesContratAnnexe;
use Illuminate\Http\Request;

class TermesContratsAnnexesController extends TermesContratsController
{
    public function allAnnexes()
    {
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'date_using', 'type')
            ->with('site', 'user')->isAnnexe()->get();
        return response()->json(['termes' => $termes]);
    }

    public function store(Request $request)
    {
        $request->validate(TermesContratAnnexe::RULES);
        $terme = new TermesContratAnnexe($request->all());
        $terme->codeGenerate();
        $terme->save();
        $message = "Les termes $terme->code ont été crées avec succès.";
        return response()->json(['message' => $message, 'id' => $terme->id]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(TermesContratAnnexe::RULES);
        $terme = TermesContratAnnexe::find($id);
        $terme->update($request->all());
        $message = "Les termes $terme->code ont été modifiés avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashedAnnexes()
    {
        $termes = TermesContratAnnexe::select('id', 'code', 'user_id', 'site_id', 'date_using', 'type')
            ->with('site', 'user')->onlyTrashed()->isAnnexe()->get();
        return response()->json(['termes' => $termes]);
    }
}
