<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Paiement\PaiementInitialResource;
use App\Http\Resources\Paiement\PaiementLoyerResource;
use App\Models\Exploitation\Paiement;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaiementController extends Controller
{

    public function getReleve(Request $request): JsonResponse
    {
        $facture = Facture::select('id', 'code', 'contrat_id', 'avance', 'caution', 'pas_porte', 'frais_dossier', 'frais_amenagement')
            ->where('contrat_id', (int) $request->query('id'))->isInitiale()->first();

        $initiales = !empty($facture) ? Paiement::select('id', 'facture_id', 'ordonnancement_id', 'montant')
            ->where('facture_id', $facture->id)
            ->whereRelation('contrat', 'contrats.id', (int) $request->query('id'))
            ->whereHas('ordonnancement.encaissement',
                fn(Builder $query) : Builder => $query->whereBetween('created_at', [
                    $request->query('start'), $request->query('end') . ' ' . '23:59:59',
                ]))
            ->with(['ordonnancement:id,code' => ['encaissement:id,code,ordonnancement_id,created_at,payable_type']])->get(): [];

        $loyers = Paiement::select('id', 'facture_id', 'ordonnancement_id', 'montant')
            ->whereRelation('contrat', 'contrats.id', (int) $request->query('id'))
            ->whereHas('facture', fn($query) => $query->isLoyer())
            ->whereHas('ordonnancement.encaissement',
                fn(Builder $query): Builder => $query->whereBetween('created_at', [
                    $request->query('start'), $request->query('end') . ' ' . '23:59:59',
                ]))
            ->with([
                'ordonnancement:id,code,timbre,total' => ['encaissement:id,code,ordonnancement_id,created_at,payable_type'], 'facture:id,code,periode',
            ])->get();

        return response()->json([
            'initiales' => PaiementInitialResource::collection($initiales),
            'factureInitiale' => FactureInitialeResource::make($facture),
            'loyers' => PaiementLoyerResource::collection($loyers),
        ]);
    }
}
