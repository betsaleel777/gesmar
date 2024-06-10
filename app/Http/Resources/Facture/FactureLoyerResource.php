<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureLoyerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'status' => $this->whenAppended('status'),
            'loyer' => $this->whenNotNull($this->montant_loyer),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
        ];
    }
}
