<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Emplacement\PavillonResource;
use App\Http\Resources\Emplacement\PavillonSelectResource;
use App\Models\Architecture\Pavillon;
use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class PavillonsController extends Controller
{

    private static function pusher(int $site, int $nombre): void
    {
        $start = (int) Site::with('pavillons')->findOrFail($site)->pavillons->count();
        $fin = $start + $nombre;
        while ($start < $fin) {
            $start++;
            $pavillon = new Pavillon();
            $pavillon->site_id = $site;
            $pavillon->nom = 'pavillon ' . $start;
            $pavillon->code = (string) $start;
            $pavillon->save();
        }
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Pavillon::class);
        $requete = Pavillon::select('id', 'nom', 'site_id', 'created_at')->with('site:id,nom');
        $pavillons = $response->allowed() ? $requete->get() : $requete->owner()->get();
        return response()->json(['pavillons' => PavillonResource::collection($pavillons)]);
    }

    public function search(Request $request): JsonResource
    {
        $response = Gate::inspect('viewAny', Pavillon::class);
        $query = Pavillon::with('site')->where('nom', 'LIKE', '%' . $request->query('search') . '%')
            ->orWhereHas('site', fn(Builder $query) => $query->where('nom', 'LIKE', '%' . $request->query('search') . '%'));
        $pavillons = $response->allowed() ? $query->get() : $query->owner()->get();
        return PavillonSelectResource::collection($pavillons);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Pavillon::class);
        if ($request->automatiq) {
            $request->validate(Pavillon::MIDDLE_RULES);
            self::pusher($request->site_id, $request->nombre);
        } else {
            $request->validate(Pavillon::RULES);
            $pavillon = new Pavillon($request->all());
            $pavillon->code = (string) (Site::with('pavillons')->findOrFail((int) $request->site_id)->pavillons->count() + 1);
            $pavillon->save();
        }
        $message = "Le pavillon $request->nom a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $pavillon = Pavillon::findOrFail($id);
        $this->authorize('update', $pavillon);
        $request->validate(Pavillon::RULES);
        $pavillon->nom = $request->nom;
        $pavillon->site_id = $request->site_id;
        $pavillon->save();
        return response()->json(['message' => 'Le pavillon a été modifié crée avec succès.']);
    }

    public function trash(int $id): JsonResponse
    {
        $pavillon = Pavillon::find($id);
        $this->authorize('delete', $pavillon);
        $pavillon->delete();
        return response()->json(['message' => "Le pavillon $pavillon->nom a été supprimé avec succès."]);
    }

    public function restore(int $id): JsonResponse
    {
        $pavillon = Pavillon::withTrashed()->find($id);
        $this->authorize('restore', $pavillon);
        $pavillon->restore();
        return response()->json(['message' => "Le pavillon $pavillon->nom a été restauré avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Pavillon::class);
        $requete = Pavillon::select('id', 'nom', 'site_id', 'created_at')->with('site:id,nom');
        $pavillons = $response->allowed() ? $requete->onlyTrashed()->get() : $requete->owner()->onlyTrashed()->get();
        return response()->json(['pavillons' => $pavillons]);
    }

    public function show(int $id): JsonResponse
    {
        $pavillon = Pavillon::select('id', 'nom', 'site_id')->find($id);
        $this->authorize('view', $pavillon);
        return response()->json(['pavillon' => PavillonResource::make($pavillon)]);
    }

    public function getByMarche(int $id): JsonResponse
    {
        $response = Gate::inspect('viewAny', Pavillon::class);
        $pavillons = $response->allowed() ? Pavillon::where('site_id', $id)->get() : Pavillon::where('site_id', $id)->owner()->get();
        return response()->json(['pavillons' => PavillonResource::collection($pavillons)]);
    }
}
