<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Site;
use App\Models\Architecture\Zone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ZonesController extends Controller implements StandardControllerInterface
{
    /**
     * Undocumented function
     *
     * @param  array<int>  $ids
     * @return array<int, Collection<int, Zone>>
     */
    public static function getMany(array $ids): array
    {
        $niveaux = Niveau::with('zones')->findMany($ids);
        $zones = [];
        /**
         * @var $niveau Niveau
         */
        foreach ($niveaux as $niveau) {
            $zones[] = $niveau->zones;
        }

        return $zones;
    }

    /**
     * Undocumented function
     *
     * @param  array<int>  $niveaux
     * @param  int  $nombre
     * @return void
     */
    private static function pusher(array $niveaux, int $nombre): void
    {
        foreach ($niveaux as $niveau) {
            $start = (int) Niveau::findOrFail($niveau)->zones->count();
            $fin = $start + $nombre;
            while ($start < $fin) {
                $start++;
                $zone = new Zone();
                $zone->niveau_id = $niveau;
                $zone->nom = 'zone ' . $start;
                $zone->code = (string) $start;
                $zone->save();
            }
        }
    }

    public function all(): JsonResponse
    {
        $zones = Zone::all();
        return response()->json(['zones' => $zones]);
    }

    public function store(Request $request): JsonResponse
    {
        if ($request->automatiq) {
            $request->validate(Zone::MIDDLE_RULES);
            self::pusher($request->niveaux, $request->nombre);
        } else {
            $request->validate(Zone::RULES);
            $zone = new Zone($request->all());
            $zone->code = (string) (Niveau::with('zones')->findOrFail($request->niveau_id)->zones->count() + 1);
            $zone->save();
        }
        $message = "La zone $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function push(Request $request): JsonResponse
    {
        $request->validate(Zone::PUSH_RULES);
        self::pusher($request->niveaux, $request->nombre);
        $message = "$request->nombre zones ont été crée avec succès.";
        return response()->json(['message' => $message, 'zones' => self::getMany($request->niveaux)]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $request->validate(Zone::RULES);
        $zone = Zone::findOrFail($id);
        $zone->nom = $request->nom;
        $zone->niveau_id = $request->niveau_id;
        $zone->save();
        $message = 'La zone a été modifié avec succès.';
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();
        $message = "La zone $zone->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $zone = Zone::withTrashed()->find($id);
        $zone->restore();
        $message = "La zone $zone->nom a été restauré avec succès.";
        return response()->json(['message' => $message]);
    }

    public function trashed(): JsonResponse
    {
        $zones = Zone::onlyTrashed()->get();
        return response()->json(['zones' => $zones]);
    }

    public function show(int $id): JsonResponse
    {
        $zone = Zone::withTrashed()->find($id);
        return response()->json(['zone' => $zone]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $zones = Site::with('zones')->findOrFail($id)->zones;
        return response()->json(['zones' => $zones]);
    }
}
