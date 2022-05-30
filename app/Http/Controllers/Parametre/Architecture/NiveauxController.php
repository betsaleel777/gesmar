<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Pavillon;
use Illuminate\Http\Request;

class NiveauxController extends Controller
{
    private static function getMany(array $ids)
    {
        $pavillons = Pavillon::with('niveaux')->findMany($ids);
        $niveaux = [];
        foreach ($pavillons as $pavillon) {
            $niveaux[] = $pavillon->niveaux;
        }
        return $niveaux;
    }

    private static function pusher(int $site, int $nombre)
    {
        $start = (int) Pavillon::find($site)->niveaux->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $niveau = new Niveau();
            $niveau->pavillon_id = $site;
            $niveau->nom = 'niveau ' . $start;
            $niveau->code = $start;
            $niveau->save();
        }
    }

    public function all()
    {
        $niveaux = Niveau::with('pavillon.site')->get();
        return response()->json(['niveaux' => $niveaux]);
    }

    public function store(Request $request)
    {
        if ($request->automatiq) {
            $request->validate(Niveau::MIDDLE_RULES);
            self::pusher($request->pavillon_id, $request->nombre);
        } else {
            $request->validate(Niveau::RULES);
            $pavillon = new Pavillon($request->all());
            $pavillon->code = (int) Niveau::find($request->pavillon_id)->pavillons->count() + 1;
            $pavillon->save();
        }
        $message = "Le niveau $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(Request $request, int $id)
    {
        $request->validate(Niveau::RULES);
        $niveau = Niveau::find($id);
        $niveau->nom = $request->nom;
        $niveau->pavillon_id = $request->pavillon_id;
        $niveau->save();
        $message = "Le niveau a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Niveau::PUSH_RULES);
        self::pusher($request->id, $request->nombre);
        $message = "$request->nombre niveaux ont été crée avec succès.";
        return response()->json(['message' => $message, 'niveaux' => self::getMany($request->pavillons)]);
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
        $niveaux = Niveau::with('pavillon')->onlyTrashed()->get();
        return response()->json(['niveaux' => $niveaux]);
    }

    public function show(int $id)
    {
        $niveau = Niveau::withTrashed()->find($id);
        return response()->json(['niveau' => $niveau]);
    }

    public function getByPavillons(array $ids)
    {
        return response()->json(['niveaux' => self::getMany($ids)]);
    }

    public function getByPavillon(int $id)
    {
        $niveaux = Pavillon::find($id)->niveaux;
        return response()->json(['niveaux' => $niveaux]);
    }
}
