<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureEquipementListResource;
use App\Http\Resources\Facture\FactureEquipementResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class FactureEquipementController extends Controller
{
    const RELATIONS = ['contrat' => ['emplacement', 'personne']];

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'equipement']);
        $query = Facture::with(self::RELATIONS)->isEquipement()->isFacture();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => FactureEquipementListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'equipement']);
        $query = Facture::with(['contrat' => ['emplacement', 'personne'], 'equipement.abonnementActuel'])->isEquipement()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureEquipementListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'equipement']);
        $query = Facture::with(['contrat' => ['emplacement', 'personne'], 'equipement.abonnementActuel'])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn(Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn(Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn(Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isEquipement()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureEquipementListResource::collection($factures);
    }

    public function facturesValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'equipement']);
        $query = Facture::with(self::RELATIONS)->isPaid()->isEquipement();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'equipement']);
        $query = Facture::with(self::RELATIONS)->isUnpaid()->isEquipement();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with([
            'contrat:id,code,code_contrat,debut,fin,emplacement_id' => ['emplacement:id,code'],
            'equipement:id,code,type_equipement_id' => ['type'],
            'personne'
        ])->isEquipement()->withNameResponsible()->withUnpaidAmount($id)->find($id);
        $this->authorize('view', [$facture, 'equiepement']);
        return response()->json(['facture' => FactureEquipementResource::make($facture)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', [Facture::class, 'equipement']);
        foreach ($request->factures as $ligne) {
            $facture = new Facture($ligne);
            $facture->montant_equipement = $ligne['prix_unitaire'];
            $facture->codeGenerate(config('constants.EQUIPEMENT_FACTURE_PREFIXE'));
            $facture->date_limite = $request->date_limite;
            $facture->save();
            $facture->facturable();
        }
        return response()->json(['message' => "Les factures d'équipement ont été crée avec succès."]);
    }
}
