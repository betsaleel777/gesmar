<?php

namespace App\Http\Resources\Paiement;

use App\Http\Resources\Facture\FactureLoyerResource;
use App\Http\Resources\Ordonnancement\OrdonnancementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaiementLoyerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'montant' => $this->montant,
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
            'facture' => FactureLoyerResource::make($this->whenLoaded('facture')),
        ];
    }
}
