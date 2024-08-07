<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Events\EquipementRegistred;
use App\Events\EquipementRemoved;
use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\EquipementListResource;
use App\Http\Resources\Abonnement\EquipementResource;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class EquipementsController extends Controller
{
    private static function codeGenerate(int $site): array
    {
        $rang = (string) (Site::findOrFail($site)->equipements->count() + 1);
        return ['code' => 'EQU' . str_pad($rang, 5, '0', STR_PAD_LEFT) . Carbon::now()->format('y'), 'rang' => $rang];
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Equipement::class);
        $requete = Equipement::select('id', 'nom', 'code', 'prix_unitaire', 'prix_fixe', 'type_equipement_id', 'site_id', 'emplacement_id')->with('site:id,nom', 'type:id,nom');
        $equipements = $response->allowed() ? $requete->get() : $requete->owner()->get();
        return response()->json(['equipements' => EquipementListResource::collection($equipements)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Equipement::class);
        $query = Equipement::select('id', 'nom', 'code', 'prix_unitaire', 'prix_fixe', 'type_equipement_id', 'site_id', 'emplacement_id', 'abonnement', 'liaison')->with('site:id,nom', 'type:id,nom');
        $equipements = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return EquipementListResource::collection($equipements);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Equipement::class);
        $query = Equipement::select(
            'nom',
            'code',
            'prix_unitaire',
            'prix_fixe',
            'type_equipement_id',
            'site_id',
            'emplacement_id',
            'abonnement',
            'liaison'
        )->with('site:id,nom', 'type:id,nom')
            ->where('code', 'LIKE', "%$search%")->orWhere('nom', 'LIKE', "%$search%")
            ->orWhereHas('type', fn (Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"));
        $equipements = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return EquipementListResource::collection($equipements);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Equipement::class);
        $request->validate(Equipement::RULES);
        $equipement = new Equipement($request->all());
        ['code' => $code, 'rang' => $rang] = self::codeGenerate($request->site_id);
        $equipement->code = $code;
        $equipement->nom = 'EQUIPEMENT ' . $rang;
        $equipement->save();
        is_null($equipement->emplacement_id) ?: $equipement->lier();
        EquipementRegistred::dispatchIf(!is_null($equipement->emplacement_id), $equipement);
        return response()->json(['message' => "L'équipement $equipement->nom a été enregistré avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $equipement = Equipement::find($id);
        $this->authorize('update', $equipement);
        $request->validate(Equipement::RULES);
        $ancienEmplacement = (int) $equipement->emplacement_id;
        $equipement->update($request->all());
        $eventCondition = $ancienEmplacement !== (int) $equipement->emplacement_id;
        EquipementRegistred::dispatchIf($eventCondition, $equipement, $ancienEmplacement);
        return response()->json(['message' => "L'équipement $equipement->nom a été modifié avec succès."]);
    }

    public function trash(int $id): JsonResponse
    {
        $equipement = Equipement::find($id);
        $this->authorize('delete', $equipement);
        $equipement->delete();
        EquipementRemoved::dispatch($equipement);
        return response()->json(['message' => "L'équipement $equipement->nom a été supprimé avec succès."]);
    }

    public function trashed(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Equipement::class);
        $query = Equipement::onlyTrashed();
        $equipements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['equipements' => $equipements]);
    }

    public function restore(int $id): JsonResponse
    {
        $equipement = Equipement::withTrashed()->find($id);
        $this->authorize('restore', $equipement);
        $equipement->restore();
        return response()->json(['message' => "L'équipement $equipement->nom a été restauré avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        $equipement = Equipement::with('emplacement')->withTrashed()->find($id);
        $this->authorize('view', $equipement);
        return response()->json(['equipement' => $equipement]);
    }

    public function getUnlinkedsubscribed(): JsonResource
    {
        return EquipementResource::collection(Equipement::unlinked()->unsubscribed()->get());
    }

    /**
     * Récupère les équipements non abonnés et non liés selon le marché et conserve l'équipement déjà lié de l'emplacement
     */
    public function getGearsForContratView(int $id, int $emplacement, int $site): JsonResponse
    {
        $equipementLinked = Equipement::where('type_equipement_id', $id)->where('emplacement_id', $emplacement)->first();
        $equipements = Equipement::where('site_id', $site)->where('type_equipement_id', $id)->unlinked()->unsubscribed()->get();
        empty($equipementLinked) ?: $equipements->push($equipementLinked);
        return response()->json(['equipements' => $equipements]);
    }
}
