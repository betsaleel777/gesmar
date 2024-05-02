<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use App\Http\Resources\Personne\PersonneResource;
use App\Http\Resources\ServiceAnnexeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAnnexeListResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'status' => $this->whenAppended('status'),
            'montant' => $this->whenNotNull($this->montant_annexe),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
            'personne' => PersonneResource::make($this->whenLoaded('personne')),
            'annexe' => ServiceAnnexeResource::make($this->whenLoaded('annexe')),
        ];
    }
}
