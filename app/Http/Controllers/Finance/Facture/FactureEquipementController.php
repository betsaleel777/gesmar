<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureEquipementListResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureEquipementController extends Controller
{
    const RELATIONS = ['contrat' => ['emplacement', 'personne']];
    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isEquipement()->isFacture()->get();
        return response()->json(['factures' => FactureEquipementListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement']])->isEquipement()->isFacture()->paginate(10);
        return FactureEquipementListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn (Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn (Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->isEquipement()->isFacture()->paginate(10);

        return FactureEquipementListResource::collection($factures);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isEquipement()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(['contrat.site', 'annexe'])->isEquipement()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        foreach ($request->all() as $ligne) {
            $facture = new Facture($ligne);
            $facture->codeGenerate(EQUIPEMENT_FACTURE_PREFIXE);
            $facture->save();
            $facture->facturable();
        }
        $message = "Les factures d'équipement ont été crée avec succès.";
        return response()->json(['message' => $message]);
    }
}
