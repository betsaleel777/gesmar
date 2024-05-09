<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Emplacement\NiveauListResource;
use App\Http\Resources\Emplacement\NiveauResource;
use App\Http\Resources\Emplacement\NiveauSelectResource;
use App\Interfaces\StandardControllerInterface;
use App\Models\Architecture\Niveau;
use App\Models\Architecture\Pavillon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class NiveauxController extends Controller implements StandardControllerInterface
{
    /**
     * Undocumented function
     */
    private static function pusher(int $pavillon, int $nombre): void
    {
        $start = (int) Pavillon::with('niveaux')->findOrFail($pavillon)->niveaux->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $niveau = new Niveau();
            $niveau->pavillon_id = $pavillon;
            $niveau->nom = 'niveau ' . $start;
            $niveau->code = (string) $start;
            $niveau->save();
        }
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Niveau::class);
        $request = Niveau::select('id', 'nom', 'pavillon_id', 'created_at')
            ->with('pavillon:pavillons.id,pavillons.nom', 'site:sites.id,sites.nom');
        $niveaux = $response->allowed() ? $request->get() : $request->owner()->get();
        return response()->json(['niveaux' => NiveauListResource::collection($niveaux)]);
    }

    public function search(Request $request): JsonResource
    {
        $response = Gate::inspect('viewAny', Niveau::class);
        $query = Niveau::with('site', 'pavillon')->where('nom', 'LIKE', '%' . $request->query('search') . '%')
            ->orWhereHas('site', fn(Builder $query) => $query->where('sites.nom', 'LIKE', '%' . $request->query('search') . '%'))
            ->orWhereHas('pavillon', fn(Builder $query) => $query->where('pavillons.nom', 'LIKE', '%' . $request->query('search') . '%'));
        $niveaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return NiveauSelectResource::collection($niveaux);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Niveau::class);
        if ($request->automatiq) {
            $request->validate(Niveau::MIDDLE_RULES);
            self::pusher($request->pavillon_id, $request->nombre);
        } else {
            $request->validate(Niveau::RULES);
            $niveau = new Niveau($request->all());
            $pavillon = Pavillon::with('niveaux')->findOrFail((int) $request->pavillon_id);
            $niveau->code = (string) ($pavillon->niveaux->count() + 1);
            $niveau->save();
        }
        return response()->json(['message' => "Le niveau $request->nom a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $niveau = Niveau::findOrFail($id);
        $this->authorize('update', $niveau);
        $request->validate(Niveau::RULES);
        $niveau->nom = $request->nom;
        $niveau->pavillon_id = $request->pavillon_id;
        $niveau->save();
        return response()->json(['message' => 'Le niveau a été modifié avec succès.']);
    }

    public function trash(int $id): JsonResponse
    {
        $niveau = Niveau::findOrFail($id);
        $this->authorize('delete', $niveau);
        $niveau->delete();
        return response()->json(['message' => "Le niveau $niveau->nom a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $niveau = Niveau::withTrashed()->find($id);
        $this->authorize('restore', $niveau);
        $niveau->restore();
        return response()->json(['message' => "Le niveau $niveau->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Niveau::class);
        $query = Niveau::with('pavillon')->onlyTrashed();
        $niveaux = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['niveaux' => $niveaux]);
    }

    public function show(int $id): JsonResponse
    {
        $niveau = Niveau::select('id', 'nom', 'pavillon_id', 'created_at')
            ->with('pavillon:pavillons.id,pavillons.nom', 'site:sites.id,sites.nom')->find($id);
        $this->authorize('view', $niveau);
        return response()->json(['niveau' => NiveauResource::make($niveau)]);
    }

    public function getByPavillon(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Niveau::class);
        $niveaux = $response->allowed() ? Niveau::where('pavillon_id', $id)->get() : Niveau::where('pavillon_id', $id)->owner()->get();
        return response()->json(['niveaux' => $niveaux]);
    }
}
