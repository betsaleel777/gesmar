<?php

namespace App\Http\Controllers\Caisse;

use App\Events\OuvertureRegistred;
use App\Http\Controllers\Controller;
use App\Http\Resources\Caisse\OuvertureListResource;
use App\Http\Resources\Caisse\OuvertureResource;
use App\Models\Caisse\Ouverture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class OuvertureController extends Controller
{
    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Ouverture::class);
        $ouvertures = $response->allowed() ? Ouverture::get() : Ouverture::owner()->get();
        return response()->json(['ouvertures' => OuvertureListResource::collection($ouvertures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Ouverture::class);
        $query = Ouverture::with('guichet.site:id,nom', 'guichet:id,nom,site_id', 'caissier:id,user_id', 'caissier.user:id,name');
        $ouvertures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return OuvertureListResource::collection($ouvertures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Ouverture::class);
        $query = Ouverture::with('guichet.site:id,nom', 'guichet:id,nom,site_id', 'caissier:id,user_id', 'caissier.user:id,name')
            ->whereRaw("DATE_FORMAT(ouvertures.created_at,'%d-%m-%Y') LIKE ?", "$search%")
            ->orWhere('code', 'LIKE', "%$search%")
            ->orWhereHas('caissier.user', fn(Builder $query): Builder => $query->where('name', 'LIKE', "%$search%"))
            ->orWhereHas('guichet', fn(Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"));
        $ouvertures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return OuvertureListResource::collection($ouvertures);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Ouverture::class);
        $request->validate(Ouverture::RULES);
        $ouverture = new Ouverture($request->all());
        $ouverture->codeGenerate();
        $ouverture->save();
        $ouverture->setUsing();
        OuvertureRegistred::dispatch($ouverture);
        return response()->json(['message' => "L'ouverture $ouverture->code a été crée avec succès"]);
    }

    public function show(int $id): JsonResponse
    {
        $ouverture = Ouverture::findOrFail($id);
        $this->authorize('view', $ouverture);
        return response()->json(['ouverture' => $ouverture]);
    }

    public function exists(int $id): JsonResponse
    {
        $exists = Ouverture::where('caissier_id', $id)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function getCurrentByCaissier(int $id): JsonResponse
    {
        $ouverture = Ouverture::with('encaissements.ordonnancement')->where('caissier_id', $id)->using()->first();
        $this->authorize('view', $ouverture);
        return empty($ouverture) ? response()->json(['message' => "il n'y a aucune caisse ouverte actuellement pour cet utilisateur"])
        : response()->json(['ouverture' => OuvertureResource::make($ouverture)]);
    }

    public function getUsingByCaissier(int $id)
    {
        $exists = Ouverture::where('caissier_id', $id)->using()->exists();
        return response()->json(['exists' => $exists]);
    }
}
