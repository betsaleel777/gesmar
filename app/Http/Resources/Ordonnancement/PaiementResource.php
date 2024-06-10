<?php

namespace App\Http\Resources\Ordonnancement;

use App\Http\Resources\Facture\FactureResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'ordonnancement_id' => $this->ordonnancement_id,
            'facture_id' => $this->facture_id,
            'created_at' => $this->created_at,
            'montant' => $this->whenNotNull($this->montant),
            'facture' => FactureResource::make($this->whenLoaded('facture')),
            'ordonnancement' => OrdonnancementResource::make($this->whenLoaded('ordonnancement')),
        ];
    }
}
