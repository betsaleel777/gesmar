<?php

namespace App\Http\Resources\Abonnement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\TypeEquipement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property TypeEquipement resource
 */
class TypeEquipementResource extends JsonResource
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
            'nom' => $this->when(!empty($this->nom), str($this->nom)->lower()),
            'frais_penalite' => $this->whenNotNull($this->resource->frais_penalite),
            'caution_abonnement' => $this->whenNotNull($this->resource->caution_abonnement),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
