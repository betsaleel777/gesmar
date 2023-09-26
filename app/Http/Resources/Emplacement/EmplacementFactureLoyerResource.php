<?php

namespace App\Http\Resources\Emplacement;

use App\Models\Architecture\Emplacement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Emplacement $resource
 */
class EmplacementFactureLoyerResource extends JsonResource
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
            'code' => $this->resource->code,
            'loyer' => $this->resource->loyer,
            'contrat_id' => $this->whenLoaded('contratActuel', $this->resource->contratActuel->id),
            'client' => $this->when(
                $this->resource->relationLoaded('contratActuel') and $this->resource->contratActuel->relationLoaded('personne'),
                fn () => $this->resource->contratActuel->personne->nomComplet
            ),
        ];
    }
}
