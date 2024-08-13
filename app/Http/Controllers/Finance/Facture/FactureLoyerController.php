<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureLoyerListResource;
use App\Http\Resources\Facture\FactureLoyerResource;
use App\Models\Architecture\Emplacement;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class FactureLoyerController extends Controller
{
    const RELATIONS = ['contrat.site', 'contrat.emplacement', 'contrat.personne'];

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'loyer']);
        $query = Facture::with(self::RELATIONS)->isLoyer()->isFacture();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => FactureLoyerListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'loyer']);
        $query = Facture::with(['contrat' => ['personne', 'emplacement']])->isLoyer()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureLoyerListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'loyer']);
        $query = Facture::with(['contrat' => ['personne', 'emplacement']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn(Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn(Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn(Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isLoyer()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureLoyerListResource::collection($factures);
    }

    public function facturesValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'loyer']);
        $query = Facture::with(self::RELATIONS)->isPaid()->isLoyer();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'loyer']);
        $query = Facture::with(self::RELATIONS)->isUnpaid()->isLoyer();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('contrat.emplacement.type', 'personne')->isLoyer()->withNameResponsible()->find($id);
        $this->authorize('view', [$facture, 'loyer']);
        return response()->json(['facture' => FactureLoyerResource::make($facture)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', [Facture::class, 'loyer']);
        foreach ($request->all() as $data) {
            $facture = new Facture($data);
            $facture->codeGenerate(config('constants.LOYER_FACTURE_PREFIXE'));
            $facture->save();
            $facture->facturable();
        }
        return response()->json(['message' => "Factures générées avec succès."]);
    }
}
