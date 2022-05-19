<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Zone;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    public static function getMany(array $ids)
    {
        $niveaux = Niveau::with('zones')->findMany($ids);
        $zones = [];
        foreach ($niveaux as $niveau) {
            $zones[] = $niveau->zones;
        }
        return $zones;
    }

    private static function pusher(int $site, int $nombre)
    {
        $start = (int) Niveau::find($site)->zones->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $zone = new Zone();
            $zone->niveau_id = $site;
            $zone->nom = 'zone ' . $start;
            $zone->code = $start;
            $zone->save();
        }
    }

    public function all()
    {
        $zones = Zone::with('niveau')->get();
        return response()->json(['zones' => $zones]);
    }

    public function store(Request $request)
    {
        if ($request->automatiq) {
            $request->validate(Zone::MIDDLE_RULES);
            self::pusher($request->pavillon_id, $request->nombre);
        } else {
            $request->validate(Zone::RULES);
            $zone = new Zone($request->all());
            $zone->code = (int) Niveau::find($request->niveau_id)->zones->count() + 1;
            $zone->save();
        }
        $message = "La zone $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request)
    {
        $request->validate(Zone::PUSH_RULES);
        self::pusher($request->id, $request->nombre);
        $message = "$request->nombre zones ont été crée avec succès.";
        return response()->json(['message' => $message, 'zones' => self::getMany($request->niveaux)]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate(Zone::RULES);
        $zone = Zone::find($id);
        $zone->nom = $request->nom;
        $zone->niveau_id = $request->niveau_id;
        $zone->save();
        $message = "La zone a été modifié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trash(int $id)
    {
        $zone = Zone::find($id);
        $zone->delete();
        $message = "La zone $zone->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id)
    {
        $zone = Zone::withTrashed()->find($id);
        $zone->restore();
        $message = "La zone $zone->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed()
    {
        $zones = Zone::with('niveau')->onlyTrashed()->get();
        return response()->json(['zones' => $zones]);
    }

    public function show(int $id)
    {
        $zone = Zone::withTrashed()->find($id);
        return response()->json(['zone' => $zone]);
    }

    public function getByZones(array $ids)
    {
        return response()->json(['zones' => self::getMany($ids)]);
    }

    public function getByZone(int $id)
    {
        $zones = Niveau::find($id)->zones;
        return response()->json(['zones' => $zones]);
    }
}
