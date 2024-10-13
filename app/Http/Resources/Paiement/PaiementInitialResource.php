<?php

namespace App\Http\Resources\Paiement;

use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaiementInitialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
        ];
    }
}
