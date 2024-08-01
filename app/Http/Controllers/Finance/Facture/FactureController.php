<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureAnnexeResource;
use App\Http\Resources\Facture\FactureEquipementResource;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Facture\FactureLoyerResource;
use App\Http\Resources\Facture\FactureResource;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureController extends Controller
{
    const RELATIONS = ['contrat' => ['personne', 'site', 'emplacement', 'annexe']];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->get();
        return response()->json(['factures' => FactureResource::collection($factures)]);
    }

    public function getSoldeesSearch(string $search): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement', 'annexe']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn (Builder $query): Builder => $query->where('contrats.code_contrat', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.personne', fn (Builder $query): Builder => $query->whereRaw("CONCAT(`nom`, ' ', `prenom`) LIKE ?", ['%' . $search . '%']))
            ->orWhereHas('contrat.emplacement', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.annexe', fn (Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"))->isPaid()->paginate(10);
        return FactureResource::collection($factures);
    }

    public function getPersonneSearch(int $id, string $search): JsonResource
    {
        $factures = Facture::with(['contrat' => ['emplacement', 'annexe']])->where('code', 'LIKE', "%$search%")
            ->orWhereHas('contrat', fn (Builder $query): Builder => $query->where('contrats.code_contrat', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.emplacement', fn (Builder $query): Builder => $query->where('code', 'LIKE', "%$search%"))
            ->orWhereHas('contrat.annexe', fn (Builder $query): Builder => $query->where('nom', 'LIKE', "%$search%"))->byPersonne($id)->paginate(10);
        return FactureResource::collection($factures);
    }

    public function getSoldeesPaginate(): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement', 'annexe']])->isPaid()->paginate(10);
        return FactureResource::collection($factures);
    }

    public function getPersonnePaginate(int $id): JsonResource
    {
        $factures = Facture::with(['contrat' => ['emplacement', 'annexe']])->byPersonne($id)->paginate(10);
        return FactureResource::collection($factures);
    }

    public function getNonSoldeesPaginate(): JsonResource
    {
        $factures = Facture::with(['contrat' => ['personne', 'emplacement', 'annexe']])->isUnpaid()->paginate(10);
        return FactureResource::collection($factures);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function payer(int $id): JsonResponse
    {
        $facture = Facture::find($id);
        $facture->payer();
        $facture->save();
        return response()->json(['message' => "La facture $facture->code a été payée avec succès."]);
    }

    public function getByContrat(int $id): JsonResponse
    {
        $facturesInitiales = Facture::withSum('paiements as sommeVersee', 'montant')->with(['contrat.emplacement'])->where('contrat_id', $id)
            ->isInitiale()->isFacture()->isSuperMarket()->get();
        $facturesAnnexes = Facture::withSum('paiements as sommeVersee', 'montant')->with('contrat.annexe')->where('contrat_id', $id)->isAnnexe()->isFacture()->get();
        $facturesLoyers = Facture::withSum('paiements as sommeVersee', 'montant')->with('contrat.emplacement')->where('contrat_id', $id)->isLoyer()->isFacture()->get();
        $facturesEquipements = Facture::with('contrat', 'equipement')->where('contrat_id', $id)->isEquipement()->isFacture()->get();
        return response()->json([
            'facturesInitiales' => FactureInitialeResource::collection($facturesInitiales),
            'facturesEquipements' => FactureEquipementResource::collection($facturesEquipements),
            'facturesLoyers' => FactureLoyerResource::collection($facturesLoyers),
            'facturesAnnexes' => FactureAnnexeResource::collection($facturesAnnexes),
        ]);
    }
}
