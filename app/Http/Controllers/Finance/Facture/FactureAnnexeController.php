<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Resources\Facture\FactureAnnexeListResource;
use App\Http\Resources\Facture\FactureAnnexeResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class FactureAnnexeController extends FactureController
{
    const RELATIONS = ['personne', 'annexe'];

    public function all(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'annexe']);
        $query = Facture::with(self::RELATIONS)->isAnnexe()->isFacture();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => FactureAnnexeListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'annexe']);
        $query = Facture::with(
            'personne:personnes.id,personnes.code,personnes.nom,prenom',
            'annexe:id,nom',
            'contrat:contrats.id,contrats.code,contrats.code_contrat'
        )->isAnnexe()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureAnnexeListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'annexe']);
        $query = Facture::with(
            'personne:personnes.id,personnes.code,personnes.nom,prenom',
            'annexe:id,nom',
            'contrat:contrats.id,contrats.code,contrats.code_contrat'
        )
            ->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->orWhereHas('personne', fn (Builder $query): Builder =>
            $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('annexe', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isAnnexe()->isFacture();
        $factures = $response->allowed() ? $query->paginate(10) : $query->owner()->paginate(10);
        return FactureAnnexeListResource::collection($factures);
    }

    public function facturesSoldees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'annexe']);
        $query = Facture::with(self::RELATIONS)->isPaid()->isAnnexe();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonSoldees(): JsonResponse
    {
        $response = Gate::inspect('viewAny', [Facture::class, 'annexe']);
        $query = Facture::with(self::RELATIONS)->isUnpaid()->isAnnexe()->isAnnexe();
        $factures = $response->allowed() ? $query->get() : $query->owner()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with('personne', 'annexe', 'contrat')->isAnnexe()->withNameResponsible()->find($id);
        $this->authorize('view', [$facture, 'annexe']);
        return response()->json(['facture' => FactureAnnexeResource::make($facture)]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', [Facture::class, 'annexe']);
        $request->validate(Facture::RULES);
        $facture = new Facture($request->all());
        $facture->proforma();
        $facture->codeGenerate(config('constants.ANNEXE_FACTURE_PREFIXE'));
        $facture->save();
        return response()->json(['message' => "La facture annexe: $facture->code a été crée avec succès."]);
    }
}
