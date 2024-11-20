<?php

namespace App\Http\Resources\Facture;

use Illuminate\Http\Resources\Json\JsonResource;

class FactureAutreResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'montant' => $this->caution_abonnement ?? 0,
            'created_at' => $this->whenNotNull($this->created_at?->format('d-m-Y')),
        ];
    }
}
