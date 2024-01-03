<?php

namespace App\Http\Controllers\Parametre\Architecture;

use App\Events\AbonnementRegistred;
use App\Events\AbonnementResilied;
use App\Http\Controllers\Controller;
use App\Http\Resources\Abonnement\AbonnementListResource;
use App\Http\Resources\Abonnement\AbonnementSelectResource;
use App\Models\Architecture\Abonnement;
use App\Models\Architecture\Equipement;
use App\Models\Architecture\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AbonnementsController extends Controller
{
    private static function codeGenerate(int $site): string
    {
        $site = Site::with('abonnements')->findOrFail($site);
        $rang = $site->abonnements->count() + 1;
        $place = str_pad((string) $rang, 6, '0', STR_PAD_LEFT);
        return 'AB' . str_pad((string) $site->id, 2, '0', STR_PAD_LEFT) . $place;
    }

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        if ($response->allowed()) {
            $abonnements = Abonnement::with('emplacement', 'equipement')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $abonnements = Abonnement::with('emplacement', 'equipement')->inside($sites)->get();
        }
        return response()->json(['abonnements' => AbonnementListResource::collection($abonnements)]);
    }

    public function getPaginate(): JsonResource
    {
        $abonnements = Abonnement::with('emplacement', 'equipement')->paginate(10);
        return AbonnementListResource::collection($abonnements);
    }

    public function getSearch(string $search): JsonResource
    {
        $abonnements = Abonnement::with('emplacement', 'equipement')->where('code', 'LIKE', "%$search%")
            ->orWhereHas('emplacement', fn(Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->orWhereHas('equipement', fn(Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"))->paginate(10);
        return AbonnementListResource::collection($abonnements);
    }

    public function select(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Abonnement::class);
        if ($response->allowed()) {
            $abonnements = Abonnement::with('emplacement', 'equipement.type')->get();
        } else {
            $sites = Auth::user()->sites->modelkeys();
            $abonnements = Abonnement::with('emplacement', 'equipement.type')->inside($sites)->get();
        }
        return response()->json(['abonnements' => AbonnementSelectResource::collection($abonnements)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Abonnement::class);
        $request->validate(Abonnement::RULES);
        $abonnement = new Abonnement;
        foreach ($request->equipements as $equipement) {
            $abonnement->fill($request->all());
            $abonnement->code = self::codeGenerate($request->site_id);
            $abonnement->index_depart = $equipement['index_depart'];
            $abonnement->index_autre = $equipement['index_autre'];
            $abonnement->equipement_id = $equipement['id'];
            $abonnement->save();
            AbonnementRegistred::dispatch($abonnement);
        }
        $message = "L'abonnement $abonnement->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function insert(Request $request): JsonResponse
    {
        $this->authorize('create', Abonnement::class);
        $request->validate(['equipement_id' => 'required', 'index_depart' => 'required', 'index_autre' => 'required']);
        $equipement = Equipement::with('type')->find((int) $request->equipement_id);
        $abonnement = new Abonnement($request->all());
        $abonnement->site_id = $equipement->site_id;
        $abonnement->code = self::codeGenerate($equipement->site_id);
        $abonnement->save();
        AbonnementRegistred::dispatch($abonnement);
        $message = "L'abonnement $abonnement->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $abonnement = Abonnement::findOrFail($id);
        $this->authorize('update', $abonnement);
        $request->validate(Abonnement::RULES);
        $abonnement->update($request->all());
        $message = "L'abonnement $request->code a été modifié avec succès.";
        return response()->json(['message' => $message]);
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
        $abonnement = Abonnement::with(['emplacement', 'equipement.type'])->orderBy('id', 'DESC')->firstWhere('equipement_id', $id);
        if (empty($abonnement->index_depart)) {
            $equipement = Equipement::findOrFail($id);
        }
        return response()->json(['index' => $abonnement->index_fin ?? $abonnement->index_depart ?? $equipement?->index]);
    }

    public function finish(int $id, Request $request): JsonResponse
    {
        $request->validate(Abonnement::FINISH_RULES);
        $abonnement = Abonnement::findOrFail($id);
        $abonnement->index_fin = $request->indexFin;
        $abonnement->save();
        $abonnement->stop();
        AbonnementResilied::dispatch($abonnement);
        $message = "L'abonnement $request->code a été résilié avec succès.";
        return response()->json(['message' => $message]);
    }

    public function getRentalbyMonthGear(string $date): JsonResponse
    {
        $nestedRelation = 'emplacement.contratActuel.facturesEquipements';
        $requete = Abonnement::with(['equipement', 'emplacement.contratActuel' => ['personne', 'facturesEquipements']])
            ->progressing()->whereHas('emplacement.contratActuel', fn(Builder $query) => $query->where('auto_valid', false));
        $abonnements = $requete->whereDoesntHave($nestedRelation, fn(Builder $query) => $query->where('periode', $date))->get();
        $abonnementsFactureUnpaid = $requete->whereHas($nestedRelation, fn(Builder $query) => $query->where('periode', $date)->isUnpaid())->get();
        $abonnements->merge($abonnementsFactureUnpaid)->filter();
        return response()->json(['abonnements' => $abonnements]);
    }
}
