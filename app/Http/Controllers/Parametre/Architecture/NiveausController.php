<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Pavillon;
use Illuminate\Http\Request;

class NiveausController extends Controller
{
    public static function getMany(array $ids)
    {
        $pavillons = Pavillon::with('niveaus')->findMany($ids);
        $niveaus = [];
        foreach ($pavillons as $pavillon) {
            $niveaus[] = $pavillon->niveaus;
        }
        return $niveaus;
    }

    public function all()
    {
        $niveaus = Niveau::get();
        return response()->json(['pavillons' => $niveaus]);
    }

    public function store(Request $request)
    {
        $request->validate(Niveau::RULES);
        $niveau = new Niveau($request->all());
        $niveau->save();
        $message = "Le niveau $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Niveau::PUSH_RULES);
        foreach ($request->ids as $id) {
            $start = Pavillon::find($id)->niveaus->latest()->get()->id;
            $fin = $start + $request->nombre;
            do {
                $start++;
                $niveau = new Niveau();
                $niveau->pavillon_id = $id;
                $niveau->name = 'niveau ' . $start;
                $niveau->save();
            } while ($start <= $fin);
        }
        $message = "$request->nombre niveaux ont été crée avec succès.";
        return response()->json(['message' => $message, 'niveaus' => self::getMany($request->ids)]);
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
        return response()->json(['niveaus' => $niveaus]);
    }

    public function show(int $id)
    {
        $niveau = Niveau::withTrashed()->find($id);
        return response()->json(['niveau' => $niveau]);
    }

    public function getByPavillons(array $ids)
    {
        return response()->json(['niveaus' => self::getMany($ids)]);
    }

    public function getByPavillon(int $id)
    {
        $niveaus = Pavillon::find($id)->niveaus;
        return response()->json(['niveaus' => $niveaus]);
    }
}
