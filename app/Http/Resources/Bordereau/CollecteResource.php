<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Models\Bordereau\Collecte;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Collecte resource
 */
class CollecteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'montant' => $this->whenNotNull($this->resource->montant),
            'bordereau_id' => $this->whenNotNull($this->resource->bordereau_id),
            'emplacement_id' => $this->whenNotNull($this->resource->emplacement_id),
            'jour' => $this->whenNotNull($this->resource->jour?->format('d-m-Y')),
            'created_at' => $this->whenNotNull($this->resource->created_at->format('d-m-Y')),
            'bordereau' => BordereauResource::make($this->whenLoaded('bordereau')),
            'emplacement' => EmplacementResource::make($this->whenLoaded('emplacement')),
        ];
    }
}
