<?php

namespace App\Repositories;

use App\Http\Resources\Facture\FactureAbonnementResource;
use App\Interfaces\AutreFactureInterface;
use App\Models\Finance\Facture;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAbonnementRepository implements AutreFactureInterface
{
    public function all(Request $request): JsonResource
    {
        return FactureAbonnementResource::collection(Facture::with('abonnement.equipement', 'personne')->isAbonnement()->get());
    }

    public function getPaginate(Request $request): JsonResource
    {
        $factures = Facture::select('id', 'code', 'abonnement_id', 'created_at')->with([
            'abonnement:id,code,index_depart,equipement_id,emplacement_id,contrat_id' =>
            ['equipement:id,code', 'emplacement:id,code', 'personne:personnes.id,personnes.code,nom,prenom'],
            'contrat:id,code_contrat'
        ])->isAbonnement()->paginate(10);
        return FactureAbonnementResource::collection($factures);
    }

    public function getSearch(Request $request): JsonResource
    {
        return FactureAbonnementResource::collection([]);
    }

    public function show(Request $request): JsonResource
    {
        $facture = Facture::select('id', 'code', 'abonnement_id', 'caution_abonnement', 'created_at')->with([
            'abonnement:id,code,index_depart,equipement_id,emplacement_id,contrat_id' => [
                'equipement:id,code',
                'personne:personnes.id,personnes.code,nom,prenom,ville,adresse,contact,email',
                'emplacement:id,code,zone_id,type_emplacement_id' =>
                ['type:id,nom,prefix', 'zone:zones.id,zones.nom', 'niveau:niveaux.id,niveaux.nom', 'pavillon:pavillons.id,pavillons.nom']
            ],
            'contrat:id,code_contrat'
        ])->firstWhere('abonnement_id', $request->id);
        return FactureAbonnementResource::make($facture);
    }
}
