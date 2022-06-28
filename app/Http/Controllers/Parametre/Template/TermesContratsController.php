<?php

namespace App\Http\Controllers\Parametre\Template;

use App\Http\Controllers\Controller;
use App\Models\Template\TermesContrat;

class TermesContratsController extends Controller
{
    public function all()
    {
        $termes = TermesContrat::with('site', 'user')->get();
        return response()->json(['termes' => $termes]);
    }

    public function trash(int $id)
    {
        $terme = TermesContrat::find($id);
        $terme->delete();
        $message = "Les termes $terme->titre ont été supprimés avec succès.";
        return response()->json(['message' => $message]);

    }

    public function restore(int $id)
    {
        $terme = TermesContrat::withTrashed()->find($id);
        $terme->restore();
        $message = "Les termes $terme->titre ont été restaurés avec succès.";
        return response()->json(['message' => $message]);

    }

    public function trashed()
    {
        $termes = TermesContrat::with('site', 'user')->onlyTrashed()->get();
        return response()->json(['termes' => $termes]);
    }

    public function show(int $id)
    {
        $terme = TermesContrat::with('site', 'user')->withTrashed()->find($id);
        return response()->json(['terme' => $terme]);
    }
}
