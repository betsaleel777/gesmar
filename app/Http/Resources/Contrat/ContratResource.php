<?php

namespace App\Http\Resources\Contrat;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\Facture\FactureEquipementResource;
use App\Http\Resources\Facture\FactureResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use App\Http\Resources\SiteResource;
use App\Models\Exploitation\Contrat;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Contrat $resource
 */
class ContratResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->codification(),
            'debut' => $this->whenNotNull($this->debut),
            'fin' => $this->whenNotNull($this->fin),
            'site_id' => $this->whenNotNull($this->site_id),
            'emplacement_id' => $this->whenNotNull($this->emplacement_id),
            'personne_id' => $this->whenNotNull($this->personne_id),
            'annexe_id' => $this->whenNotNull($this->annexe_id),
            'created_at' => $this->whenNotNull($this->created_at),
            'avance' => $this->whenNotNull($this->avance),
            'equipable' => $this->whenNotNull($this->equipable),
            'auto_valid' => $this->whenNotNull($this->auto_valid),
            'type' => $this->whenNotNull($this->getType()),
            'isDemande' => empty($this->code_contrat),
            'status' => $this->whenAppended('status'),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'equipements' => EquipementResource::collection($this->whenLoaded('equipements')),
            'factures' => FactureResource::collection($this->whenLoaded('factures')),
            'facturesEquipements' => FactureEquipementResource::collection($this->whenLoaded('facturesEquipements')),
            'alias' => match (true) {
                !empty($this->annexe) and $this->relationLoaded('personne') => $this->codification() . '-' . $this->annexe->code . '-' . $this->personne->alias,
                !empty($this->emplacement) and $this->relationLoaded('personne') => $this->codification() . '-' . $this->emplacement->code . '-' . $this->personne->alias,
                default => ''
            },
        ];
    }
}
