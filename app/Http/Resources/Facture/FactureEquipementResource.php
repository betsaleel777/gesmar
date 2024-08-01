<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Abonnement\EquipementResource;
use App\Http\Resources\AuditResource;
use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\Types\This;

class FactureEquipementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'index_depart' => $this->whenNotNull($this->index_depart),
            'index_fin' => $this->whenNotNull($this->index_fin),
            'status' => $this->whenAppended('status'),
            'montant_equipement' => $this->whenNotNull($this->montant_equipement),
            'frais_facture' => $this->whenNotNull($this->frais_facture),
            'prix_fixe' => $this->whenNotNull($this->prix_fixe),
            'total' => $this->whenNotNull($this->getEquipementTotalAmount()),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'equipement' => EquipementResource::make($this->whenLoaded('equipement')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'audit' => AuditResource::make($this->whenLoaded('audit')),
        ];
    }
}
