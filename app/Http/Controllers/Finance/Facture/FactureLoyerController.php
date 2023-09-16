<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureLoyerListResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureLoyerController extends Controller
{
    const RELATIONS = ['contrat.site', 'contrat.emplacement', 'contrat.personne'];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isLoyer()->isFacture()->get();
        return response()->json(['factures' => FactureLoyerListResource::collection($factures)]);
    }

    public function getPaginate(): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement']])->paginate(10);
        return FactureLoyerListResource::collection($factures);
    }

    public function getSearch(string $search): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn (Builder $query): Builder => $query->where('contrats.code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn (Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))->paginate(10);

        return FactureLoyerListResource::collection($factures);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->isLoyer()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->isLoyer()->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function store(Request $request): JsonResponse
    {
        foreach ($request->all() as $data) {
            $facture = new Facture($data);
            $facture->codeGenerate(LOYER_FACTURE_PREFIXE);
            $facture->save();
            $facture->facturable();
        }
        $message = "Factures générées avec succès.";
        return response()->json(['message' => $message]);
    }
}
