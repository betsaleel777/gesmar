<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Abonnement\EquipementResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Finance\Facture;

/**
 * @property Facture $resource
 */
class FactureEquipementListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'prix' => $this->prix_unitaire,
            'index_depart' => $this->index_depart,
            'index_fin' => $this->index_fin,
            'status' => $this->whenAppended('status'),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'equipement' => EquipementResource::make($this->whenLoaded('equipement')),
        ];
    }
}
