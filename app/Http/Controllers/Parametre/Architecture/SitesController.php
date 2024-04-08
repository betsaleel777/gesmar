<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteResource;
use App\Http\Resources\SiteSelectResource;
use App\Models\Architecture\Site;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SitesController extends Controller
{
    public function all(): JsonResponse
    {
        $this->authorize('viewAny', Site::class);
        $marches = Site::bySiteAttribuate()->get();
        return response()->json(['marches' => SiteResource::collection($marches)]);
    }

    public function select(): JsonResponse
    {
        $this->authorize('viewAny', Site::class);
        $marches = Site::select('id', 'nom')->bySiteAttribuate()->get();
        return response()->json(['marches' => SiteSelectResource::collection($marches)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Site::class);
        $request->validate(Site::RULES);
        $marche = new Site($request->all());
        $marche->save();
        return response()->json(['message' => "Le marché $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $marche = Site::findOrFail($id);
        $this->authorize('update', $marche);
        $request->validate(Site::edit_rules($id));
        $marche->nom = $request->nom;
        $marche->ville = $request->ville;
        $marche->pays = $request->pays;
        $marche->commune = $request->commune;
        $marche->postale = $request->postale;
        $marche->save();
        return response()->json(['message' => "Le marché $request->nom a été crée avec succès."]);
    }

    public function push(Request $request): JsonResponse
    {
        $this->authorize('create', Site::class);
        $request->validate(Site::RULES);
        $marche = new Site($request->all());
        $marche->save();
        $freshMarche = $marche->fresh();
        return response()->json(['message' => "Le marché $request->nom a été crée avec succès.", 'marche' => $freshMarche]);
    }

    public function trash(int $id): JsonResponse
    {
        $this->authorize('delete', Site::class);
        $marche = Site::find($id);
        $marche->delete();
        return response()->json(['message' => "Le marché $marche->nom a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $this->authorize('restore', Site::class);
        $marche = Site::withTrashed()->find($id);
        $marche->restore();
        return response()->json(['message' => "Le marché $marche->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $this->authorize('viewAny', Site::class);
        $marches = Site::onlyTrashed()->bySiteAttribuate()->get();
        return response()->json(['marches' => $marches]);
    }

    public function show(int $id): JsonResponse
    {
        $this->authorize('view', Site::class);
        $marche = Site::withTrashed()->find($id);
        return response()->json(['marche' => $marche]);
    }

    public function showStructure(int $id): JsonResponse
    {
        $this->authorize('view', Site::class);
        return response()->json(['structure' => self::structurer($id)]);
    }

    public function structure(): JsonResponse
    {
        $this->authorize('view', Site::class);
        return response()->json(['structure' => self::structurer()]);
    }

    /**
     * Undocumented function
     *
     * @param  int|null  $id
     * @return Collection<int, mixed>
     */
    private static function structurer(int $id = null): Collection
    {
        if (empty($id)) {
            $sites = Site::select('id', 'nom')->with([
                'pavillons' => function ($query) {
                    $query->withCount('niveaux');
                },
                'pavillons.niveaux' => function ($query) {
                    $query->withCount('zones');
                },
                'pavillons.niveaux.zones' => function ($query) {
                    $query->withCount('emplacements');
                },
                'pavillons.niveaux.zones.emplacements',
            ])->withCount('pavillons')->get();
        } else {
            $sites = Site::select('id', 'nom')->with([
                'pavillons' => function ($query) {
                    $query->withCount('niveaux');
                },
                'pavillons.niveaux' => function ($query) {
                    $query->withCount('zones');
                },
                'pavillons.niveaux.zones' => function ($query) {
                    $query->withCount('emplacements');
                },
                'pavillons.niveaux.zones.emplacements',
            ])->withCount('pavillons')->findOrFail($id)->get();
        }

        $structure = $sites->map(function ($site) {
            return new Collection([
                'name' => $site->nom,
                'value' => (int) $site->pavillons_count,
                'children' => $site->pavillons->map(
                    function ($pavillon) {
                        return new Collection([
                            'name' => $pavillon->nom,
                            'value' => (int) $pavillon->niveaux_count,
                            'children' => $pavillon->niveaux->map(
                                function ($niveau) {
                                    return new Collection([
                                        'name' => $niveau->nom,
                                        'value' => (int) $niveau->zones_count,
                                        'children' => $niveau->zones->map(
                                            function ($zone) {
                                                if ((int) $zone->emplacements_count === 0) {
                                                    return new Collection([
                                                        'name' => $zone->nom,
                                                        'value' => 1,
                                                    ]);
                                                } else {
                                                    return new Collection([
                                                        'name' => $zone->nom,
                                                        'value' => (int) $zone->emplacements_count,
                                                        'children' => $zone->emplacements->map(
                                                            function ($emplacement) {
                                                                return new Collection([
                                                                    'name' => $emplacement->code,
                                                                    'value' => 1,
                                                                ]);
                                                            }
                                                        ),
                                                    ]);
                                                }
                                            }
                                        ),
                                    ]);
                                }
                            ),
                        ]);
                    }
                ),
            ]);
        });
        return $structure;
    }
}
