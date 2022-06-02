<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Site;
use Illuminate\Http\Request;

class SitesController extends Controller implements StandardControllerInterface
{
    public function all()
    {
        $marches = Site::get();
        return response()->json(['marches' => $marches]);
    }

    public function store(Request $request)
    {
        $request->validate(Site::RULES);
        $marche = new Site($request->all());
        $marche->save();
        $message = "Le marché $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Site::edit_rules($id));
        $marche = Site::find($id);
        $marche->nom = $request->nom;
        $marche->ville = $request->ville;
        $marche->pays = $request->pays;
        $marche->commune = $request->commune;
        $marche->postale = $request->postale;
        $marche->save();
        $message = "Le marché $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Site::RULES);
        $marche = new Site($request->all());
        $marche->save();
        $message = "Le marché $request->nom a été crée avec succès.";
        $freshMarche = $marche->fresh();
        return response()->json(['message' => $message, 'marche' => $freshMarche]);
    }

    public function trash(int $id)
    {
        $marche = Site::find($id);
        $marche->delete();
        $message = "Le marché $marche->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $marche = Site::withTrashed()->find($id);
        $marche->restore();
        $message = "Le marché $marche->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $marches = Site::onlyTrashed()->get();
        return response()->json(['marches' => $marches]);
    }

    public function show(int $id)
    {
        $marche = Site::withTrashed()->find($id);
        return response()->json(['marche' => $marche]);
    }
}
