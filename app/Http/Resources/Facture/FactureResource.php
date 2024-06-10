<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->whenNotNull($this->code),
            'montant' => $this->whenNotNull($this->montant_annexe),
            'loyer' => $this->whenNotNull($this->montant_loyer),
            'periode' => $this->whenNotNull($this->periode),
            'status' => $this->whenAppended('status'),
            'type' => $this->getType(),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
        ];
    }
}
