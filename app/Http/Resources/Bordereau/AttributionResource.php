<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\Emplacement\EmplacementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributionResource extends JsonResource
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
            'jour' => $this->jour,
            'emplacement_id' => $this->emplacement_id,
            'commercial_id' => $this->commercial_id,
            'bordereau_id' => $this->bordereau_id,
            'status' => $this->whenAppended('status'),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
            'bordereau' => BordereauResource::make($this->whenLoaded('bordereau')),
            'collecte' => CollecteResource::make($this->whenLoaded('collecte')),
            'commercial' => CommercialResource::make($this->whenLoaded('commercial')),
        ];
    }
}
