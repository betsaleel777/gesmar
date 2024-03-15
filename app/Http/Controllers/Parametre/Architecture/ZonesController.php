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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $response = Gate::inspect('viewAny', Zone::class);
        $requete = Zone::select('id', 'nom', 'niveau_id', 'created_at')->with('niveau:niveaux.id,niveaux.nom,pavillon_id',
            'pavillon:pavillons.id,pavillons.nom,site_id', 'site:sites.id,sites.nom');
        if ($response->allowed()) {
            $zones = $requete->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $zones = $requete->inside($sites)->get();
        }
        return response()->json(['zones' => ZoneListResource::collection($zones)]);
    }

    public function search(Request $request): JsonResource
    {
        $response = Gate::inspect('viewAny', Zone::class);
        if ($response->allowed()) {
            $zones = Zone::with('site:sites.id,sites.nom', 'pavillon:pavillons.id,pavillons.nom', 'niveau:niveaux.id,niveaux.nom')
                ->where('nom', 'LIKE', '%' . $request->query('search') . '%')
                ->orWhereHas('site', fn(Builder $query) => $query->where('sites.nom', 'LIKE', '%' . $request->query('search') . '%'))
                ->orWhereHas('pavillon', fn(Builder $query) => $query->where('pavillons.nom', 'LIKE', '%' . $request->query('search') . '%'))
                ->orWhereHas('niveau', fn(Builder $query) => $query->where('niveaux.nom', 'LIKE', '%' . $request->query('search') . '%'))->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $zones = Zone::with('site:sites.id,sites.nom', 'pavillon:pavillons.id,pavillons.nom', 'niveau:niveaux.id,niveaux.nom')
                ->where('nom', 'LIKE', '%' . $request->query('search') . '%')
                ->orWhereHas('site', fn(Builder $query) => $query->where('sites.nom', 'LIKE', '%' . $request->query('search') . '%', true)
                        ->whereIn('sites.id', $sites))
                ->orWhereHas('pavillon', fn(Builder $query) => $query->where('pavillons.nom', 'LIKE', '%' . $request->query('search') . '%'))
                ->orWhereHas('niveau',
                    fn(Builder $query) => $query->where('niveaux.nom', 'LIKE', '%' . $request->query('search') . '%'))->get();
        }
        return ZoneSelectResource::collection($zones);
    }

    public function getForAttribution(int $id): JsonResponse
    {
        $zones = Zone::select('id', 'code', 'nom', 'niveau_id')->with('site:sites.id,sites.nom')
            ->whereHas('emplacements.type', fn(Builder $query): Builder => $query->where('auto_valid', true))
            ->whereHas('site', fn(Builder $query): Builder => $query->where('sites.id', $id))->get();
        return response()->json(['zones' => ZoneSelectResource::collection($zones)]);
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
        $response = Gate::inspect('viewAny', Zone::class);
        if ($response->allowed()) {
            $zones = Zone::with('niveau', 'pavillon', 'site')->onlyTrashed()->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $zones = Zone::with('niveau', 'pavillon', 'site')->onlyTrashed()->inside($sites)->get();
        }
        return response()->json(['zones' => $zones]);
    }

    public function show(int $id): JsonResponse
    {
        $zone = Zone::select('id', 'nom', 'niveau_id')->with('niveau:niveaux.id,niveaux.nom', 'pavillon:pavillons.id,pavillons.nom',
            'site:sites.id,sites.nom')->find($id);
        $this->authorize('view', $zone);
        return response()->json(['zone' => $zone]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $zones = Site::with('zones')->findOrFail($id)->zones;
        return response()->json(['zones' => $zones]);
    }
}
