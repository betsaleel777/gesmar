<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Emplacement\ZoneListResource;
use App\Http\Resources\Emplacement\ZoneSelectResource;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Site;
use App\Models\Architecture\Zone;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZonesController extends Controller implements StandardControllerInterface
{
    /**
     * Undocumented function
     *
     * @return void
     */
    private static function pusher(int $niveau, int $nombre): void
    {
        $start = (int) Niveau::with('zones')->findOrFail($niveau)->zones->count();
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

    public function all(): JsonResponse
    {
        $zones = Zone::all();
        return response()->json(['zones' => ZoneListResource::collection($zones)]);
    }

    public function search(Request $request): JsonResource
    {
        $zones = Zone::with('site', 'pavillon', 'niveau')->where('nom', 'LIKE', '%' . $request->query('search') . '%')
            ->orWhereHas('site', fn (Builder $query) => $query->where('sites.nom', 'LIKE', '%' . $request->query('search') . '%'))
            ->orWhereHas('pavillon', fn (Builder $query) => $query->where('pavillons.nom', 'LIKE', '%' . $request->query('search') . '%'))
            ->orWhereHas('niveau', fn (Builder $query) => $query->where('niveaux.nom', 'LIKE', '%' . $request->query('search') . '%'))->get();
        return ZoneSelectResource::collection($zones);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Zone::class);
        if ($request->automatiq) {
            $request->validate(Zone::MIDDLE_RULES);
            self::pusher($request->niveau_id, $request->nombre);
        } else {
            $request->validate(Zone::RULES);
            $zone = new Zone($request->all());
            $zone->code = (string) (Niveau::with('zones')->findOrFail($request->niveau_id)->zones->count() + 1);
            $zone->save();
        }
        $message = "La zone $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $zone = Zone::findOrFail($id);
        $this->authorize('update', $zone);
        $request->validate(Zone::RULES);
        $zone->nom = $request->nom;
        $zone->niveau_id = $request->niveau_id;
        $zone->save();
        $message = 'La zone a été modifié avec succès.';
        return response()->json(['message' => $message]);
    }

    public function trash(int $id): JsonResponse
    {
        $zone = Zone::findOrFail($id);
        $this->authorize('delete', $zone);
        $zone->delete();
        $message = "La zone $zone->nom a été supprimé avec succès.";
        return response()->json(['message' => $message]);
    }

    public function restore(int $id): JsonResponse
    {
        $zone = Zone::withTrashed()->find($id);
        $this->authorize('restore', $zone);
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
        $this->authorize('view', $zone);
        return response()->json(['zone' => $zone]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $zones = Site::with('zones')->findOrFail($id)->zones;
        return response()->json(['zones' => $zones]);
    }
}
