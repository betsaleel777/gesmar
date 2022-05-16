<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Pavillon;
use App\Models\Architecture\Site;
use Illuminate\Http\Request;

class PavillonsController extends Controller
{
    public function all()
    {
        $pavillons = Pavillon::get();
        return response()->json(['pavillons' => $pavillons]);
    }

    public function store(Request $request)
    {
        $request->validate(Pavillon::RULES);
        $pavillon = new Pavillon($request->all());
        $pavillon->save();
        $message = "Le pavillon $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Pavillon::PUSH_RULES);
        $start = (int) Site::find($request->id)->pavillons->count();
        $fin = $start + $request->nombre;
        while ($start <= $fin) {
            $pavillon = new Pavillon();
            $pavillon->site_id = $request->id;
            $pavillon->nom = 'pavillon ' . $start;
            $pavillon->save();
            $start++;
        };
        $message = "$request->nombre pavillons ont été crée avec succès.";
        $pavillons = Site::find($request->id)->pavillons;
        return response()->json(['message' => $message, 'pavillons' => $pavillons]);
    }

    public function trash(int $id)
    {
        $pavillon = Pavillon::find($id);
        $pavillon->delete();
        $message = "Le pavillon $pavillon->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $pavillon = Pavillon::withTrashed()->find($id);
        $pavillon->restore();
        $message = "Le pavillon $pavillon->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $pavillons = Pavillon::onlyTrashed()->get();
        return response()->json(['pavillons' => $pavillons]);
    }

    public function show(int $id)
    {
        $pavillon = Pavillon::withTrashed()->find($id);
        return response()->json(['pavillon' => $pavillon]);
    }

    public function getByMarche(int $id)
    {
        $pavillons = Site::find($id)->pavillons;
        return response()->json(['pavillons' => $pavillons]);
    }
}
