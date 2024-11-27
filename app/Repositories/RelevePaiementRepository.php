<?php

namespace App\Repositories;

use App\Http\Resources\Facture\FactureInitialeResource;
use App\Http\Resources\Paiement\PaiementEquipementResource;
use App\Http\Resources\Paiement\PaiementInitialResource;
use App\Http\Resources\Paiement\PaiementLoyerResource;
use App\Models\Exploitation\Paiement;
use App\Models\Finance\Facture;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RelevePaiementRepository
{
    public function getInitials(Request $request): array
    {
        $facture = Facture::select('id', 'code', 'contrat_id', 'avance', 'caution', 'pas_porte', 'frais_dossier', 'frais_amenagement')
            ->where('contrat_id', (int) $request->query('id'))->isInitiale()->first();

        $initiales = !empty($facture) ? Paiement::select('id', 'facture_id', 'ordonnancement_id', 'montant')
            ->where('facture_id', $facture->id)
            ->whereRelation('contrat', 'contrats.id', (int) $request->query('id'))
            ->whereHas(
                'ordonnancement.encaissement',
                fn(Builder $query): Builder => $query->whereBetween('created_at', [
                    $request->query('start'),
                    $request->query('end') . ' ' . '23:59:59',
                ])
            )
            ->with(['ordonnancement:id,code' => ['encaissement:id,code,ordonnancement_id,created_at,payable_type']])->get() : [];
        return [
            'initiales' => PaiementInitialResource::collection($initiales),
            'facture' => FactureInitialeResource::make($facture)
        ];
    }

    public function getRents(Request $request): JsonResource
    {
        $loyers = Paiement::select('id', 'facture_id', 'ordonnancement_id', 'montant')
            ->whereRelation('contrat', 'contrats.id', (int) $request->query('id'))
            ->whereHas('facture', fn($query) => $query->isLoyer())
            ->whereHas(
                'ordonnancement.encaissement',
                fn(Builder $query): Builder => $query->whereBetween('created_at', [
                    $request->query('start'),
                    $request->query('end') . ' ' . '23:59:59',
                ])
            )
            ->with([
                'ordonnancement:id,code,timbre,total' => ['encaissement:id,code,ordonnancement_id,created_at,payable_type'],
                'facture:id,code,periode',
            ])->get();
        return PaiementLoyerResource::collection($loyers);
    }

    public function getGears(Request $request): jsonResource
    {
        $equipements = Paiement::select('id', 'facture_id', 'ordonnancement_id', 'montant')
            ->whereRelation('contrat', 'contrats.id', (int) $request->query('id'))
            ->whereHas('facture', fn($query) => $query->isEquipement())
            ->whereHas(
                'ordonnancement.encaissement',
                fn(Builder $query): Builder => $query->whereBetween('created_at', [
                    $request->query('start'),
                    $request->query('end') . ' ' . '23:59:59',
                ])
            )
            ->with([
                'ordonnancement:id,code' => ['encaissement:id,code,ordonnancement_id,created_at,payable_type'],
                'facture:id,code,periode',
            ])->get();
        return PaiementEquipementResource::collection($equipements);
    }
}
