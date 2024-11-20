<?php

namespace App\Http\Resources\Facture;

use App\Http\Resources\Abonnement\AbonnementResource;
use App\Http\Resources\Contrat\ContratResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FactureAbonnementResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'caution_abonnement' => $this->whenNotNull($this->caution_abonnement),
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
            'abonnement' => AbonnementResource::make($this->whenLoaded('abonnement')),
            'contrat' => ContratResource::make($this->whenLoaded('contrat')),
        ];
    }
}
