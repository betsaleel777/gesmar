<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Resources\Facture\FactureAnnexeListResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAnnexeController extends FactureController
{
    const RELATIONS = ['contrat.personne', 'contrat.site', 'annexe'];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isAnnexe()->isFacture()->get();
        return response()->json(['factures' => FactureAnnexeListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $factures = Facture::with('contrat.personne', 'annexe')->isAnnexe()->isFacture()->paginate(10);
        return FactureAnnexeListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $factures = Facture::with('contrat.personne', 'annexe')->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn(Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn(Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.annexe', fn(Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isAnnexe()->isFacture()->paginate(10);
        return FactureAnnexeListResource::collection($factures);
    }

    public function facturesSoldees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonSoldees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isAnnexe()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isAnnexe()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(Facture::RULES);
        $facture = new Facture($request->all());
        $facture->proforma();
        $facture->codeGenerate(ANNEXE_FACTURE_PREFIXE);
        $facture->save();
        $message = "La facture annexe: $facture->code a été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
