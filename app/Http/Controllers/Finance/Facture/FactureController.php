<?php

namespace App\Http\Controllers\Finance\Facture;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureAnnexeResource;
use App\Http\Resources\Facture\FactureEquipementResource;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Facture\FactureLoyerResource;
use App\Http\Resources\Facture\FactureResource;
use App\Models\Finance\Facture;
use Illuminate\Http\JsonResponse;

class FactureController extends Controller
{
    const RELATIONS = ['contrat' => ['personne', 'site', 'emplacement']];

    public function all(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->get();
        return response()->json(['factures' => FactureResource::collection($factures)]);
    }

    public function facturesValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isPaid()->get();
        return response()->json(['factures' => $factures]);
    }

    public function facturesNonValidees(): JsonResponse
    {
        $factures = Facture::with(self::RELATIONS)->isUnpaid()->get();
        return response()->json(['factures' => $factures]);
    }

    public function show(int $id): JsonResponse
    {
        $facture = Facture::with(self::RELATIONS)->find($id);
        return response()->json(['facture' => $facture]);
    }

    public function payer(int $id): JsonResponse
    {
        $facture = Facture::findOrFail($id);
        $facture->payer();
        $facture->save();
        $message = "La facture $facture->code a été payée avec succès.";
        return response()->json(['message' => $message]);
    }

    public function getByContrat(int $id): JsonResponse
    {
        $facturesInitiales = Facture::withSum('paiements as sommeVersee', 'montant')->with(['contrat.emplacement'])
            ->where('contrat_id', $id)->isInitiale()->isFacture()->isSuperMarket()->get();
        $facturesAnnexes = Facture::with('contrat.annexe')->where('contrat_id', $id)->isAnnexe()->isFacture()->get();
        $facturesLoyers = Facture::with('contrat.emplacement')->where('contrat_id', $id)->isLoyer()->isFacture()->get();
        $facturesEquipements = Facture::with('contrat', 'equipement')->where('contrat_id', $id)->isEquipement()->isFacture()->get();
        return response()->json([
            'facturesInitiales' => FactureInitialeResource::collection($facturesInitiales),
            'facturesEquipements' => FactureEquipementResource::collection($facturesEquipements),
            'facturesLoyers' => FactureLoyerResource::collection($facturesLoyers),
            'facturesAnnexes' => FactureAnnexeResource::collection($facturesAnnexes),
        ]);
    }
}
