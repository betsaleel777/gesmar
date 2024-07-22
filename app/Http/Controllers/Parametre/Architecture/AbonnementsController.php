<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\AbonnementListResource;
use App\Http\Resources\Abonnement\AbonnementResource;
use App\Http\Resources\Abonnement\AbonnementSelectResource;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\Equipement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class AbonnementsController extends Controller
{
    private static function codeGenerate(): string
    {
        $abonnement = Abonnement::latest()->first();
        $rang = empty($abonnement) ? 1 : $abonnement->id;
        $place = str_pad((string) $rang, 6, '0', STR_PAD_LEFT);
        return 'AB' . $place . Carbon::now()->format('y');
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        $query = Abonnement::with('emplacement', 'equipement');
        $abonnements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['abonnements' => AbonnementListResource::collection($abonnements)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        $query = Abonnement::with('emplacement', 'equipement');
        $abonnements = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return AbonnementListResource::collection($abonnements);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        $query = Abonnement::with('emplacement', 'equipement')->where('code', 'LIKE', "%$search%")
            ->orWhereHas('emplacement', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->orWhereHas('equipement', fn (Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"));
        $abonnements = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return AbonnementListResource::collection($abonnements);
    }

    public function select(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        $query = Abonnement::with('emplacement', 'equipement.type');
        $abonnements = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['abonnements' => AbonnementSelectResource::collection($abonnements)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Abonnement::class);
        $request->validate(Abonnement::RULES);
        $abonnement = new Abonnement;
        foreach ($request->equipements as $equipement) {
            $abonnement->fill($request->all());
            $abonnement->code = self::codeGenerate();
            $abonnement->index_depart = $equipement['index_depart'];
            $abonnement->index_autre = $equipement['index_autre'];
            $abonnement->equipement_id = $equipement['id'];
            $abonnement->site_id = $equipement['site_id'];
            $abonnement->save();
            AbonnementRegistred::dispatch($abonnement);
        }
        return response()->json(['message' => "L'abonnement $abonnement->code a été crée avec succès."]);
    }

    public function insert(Request $request): JsonResponse
    {
        $this->authorize('create', Abonnement::class);
        $request->validate(['equipement_id' => 'required', 'index_depart' => 'required', 'index_autre' => 'required']);
        $equipement = Equipement::with('type')->find((int) $request->equipement_id);
        $abonnement = new Abonnement($request->all());
        $abonnement->site_id = $equipement->site_id;
        $abonnement->prix_fixe = $equipement->prix_fixe;
        $abonnement->prix_unitaire = $equipement->prix_unitaire;
        $abonnement->frais_facture = $equipement->frais_facture;
        $abonnement->code = self::codeGenerate($equipement->site_id);
        $abonnement->save();
        AbonnementRegistred::dispatch($abonnement);
        return response()->json(['message' => "L'abonnement $abonnement->code a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $abonnement = Abonnement::find($id);
        $this->authorize('update', $abonnement);
        $request->validate(Abonnement::RULES);
        $abonnement->update($request->all());
        return response()->json(['message' => "L'abonnement $request->code a été modifié avec succès."]);
    }

    public function show(int $id): JsonResponse
    {
        $abonnement = Abonnement::with(['emplacement', 'equipement.type'])->find($id);
        $this->authorize('view', $abonnement);
        return response()->json(['abonnement' => $abonnement]);
    }

    public function lastIndex(int $id): JsonResponse
    {
        $equipement = null;
        $abonnement = Abonnement::with(['emplacement', 'equipement.type'])->firstWhere('equipement_id', $id);
        if (empty($abonnement->index_depart)) {
            $equipement = Equipement::findOrFail($id);
        }
        return response()->json(['index' => $abonnement->index_fin ?? $abonnement->index_depart ?? $equipement?->index]);
    }

    public function finish(int $id, Request $request): JsonResponse
    {
        $abonnement = Abonnement::find($id);
        $this->authorize('abort', $abonnement);
        $request->validate(Abonnement::FINISH_RULES);
        $abonnement->index_fin = $request->indexFin;
        $abonnement->save();
        $abonnement->stop();
        AbonnementResilied::dispatch($abonnement);
        return response()->json(['message' => "L'abonnement $request->code a été résilié avec succès."]);
    }

    public function getRentalbyMonthGear(string $date): JsonResponse
    {
        $nestedRelation = 'emplacement.contratActuel.facturesEquipements';
        $abonnements = Abonnement::with(['equipement', 'emplacement.contratActuel' => ['personne', 'facturesEquipements']])
            ->progressing()->whereHas('emplacement.contratActuel', fn (Builder $query) => $query->where('auto_valid', false))
            ->whereDoesntHave($nestedRelation, fn (Builder $query) => $query->where('periode', $date))->get();
        return response()->json(['abonnements' => AbonnementResource::collection($abonnements)]);
    }
}
