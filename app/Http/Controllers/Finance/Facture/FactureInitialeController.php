<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureInitialeListResource;
use App\Models\Finance\Facture;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureInitialeController extends Controller
{
    const RELATIONS = ['contrat' => ['site', 'emplacement', 'personne']];

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'initiale']);
        $query = Facture::with(self::RELATIONS)->isSuperMarket()->isInitiale()->isFacture();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => FactureInitialeListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'initiale']);
        $query = Facture::with(['contrat' => ['personne', 'emplacement']])->isSuperMarket()->isInitiale()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureInitialeListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'initiale']);
        $query = Facture::with(['contrat' => ['personne', 'emplacement']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn(Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn(Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn(Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isSuperMarket()->isInitiale()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureInitialeListResource::collection($factures);
    }

    public function facturesValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'initiale']);
        $query = Facture::with(self::RELATIONS)->isSuperMarket()->isPaid()->isInitiale();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'initiale']);
        $query = Facture::with(self::RELATIONS)->isSuperMarket()->isUnpaid()->isInitiale();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isSuperMarket()->isInitiale()->find($id);
        $this->authorize('view', [$facture, 'initiale']);
        return response()->json(['facture' => FactureInitialeListResource::make($facture)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', [Facture::class, 'initiale']);
        $request->validate(Facture::initialeRules());
        $facture = new Facture($request->all());
        $facture->codeGenerate(INITIALE_FACTURE_PREFIXE);
        $facture->proforma();
        $facture->save();
        return response()->json(['message' => "La facture initiale: $facture->code a été crée avec succès."]);
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $facture = Facture::findOrFail($id);
        $this->authorize('update', [$facture, 'initiale']);
        $request->validate(Facture::INITIALE_EDIT_RULES);
        $facture->update($request->all());
        return response()->json(['message' => "La facture initiale: $facture->code a été modifiée avec succès."]);
    }
}
