<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Niveau;
use Illuminate\Http\Request;

class NiveausController extends Controller
{
    public function all()
    {
        $niveaus = Niveau::get();
        return response()->json(['niveaus' => $niveaus]);
    }

    public function store(Request $request)
    {
        $request->validate(Niveau::RULES);
        $niveau = new Niveau($request->all());
        $niveau->genererCode();
        $niveau->save();
        $message = "Le niveau $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id)
    {
        $niveau = Niveau::find($id);
        $niveau->delete();
        $message = "Le niveau $niveau->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $niveau = Niveau::withTrashed()->find($id);
        $niveau->restore();
        $message = "Le niveau $niveau->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $niveaus = Niveau::onlyTrashed()->get();
        return response()->json(['users' => $niveaus]);
    }

    public function show(int $id)
    {
        $niveau = Niveau::with('sites')->withTrashed()->find($id);
        return response()->json(['niveau' => $niveau]);
    }
}
