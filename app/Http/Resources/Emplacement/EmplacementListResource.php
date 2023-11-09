<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\Emplacement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Emplacement resource
 */
class EmplacementListResource extends JsonResource
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
            'code' => $this->whenNotNull($this->resource->code),
            'superficie' => $this->whenNotNull($this->resource->superficie),
            'loyer' => $this->whenNotNull($this->resource->loyer),
            'pas_porte' => $this->whenNotNull($this->resource->pas_porte),
            'liaison' => $this->whenNotNull($this->resource->liaison),
            'disponibilite' => $this->whenNotNull($this->resource->disponibilite),
            'type' => TypeEmplacementResource::make($this->whenLoaded('type')),
            'zone' => ZoneResource::make($this->whenLoaded('zone')),
            'niveau' => NiveauResource::make($this->whenLoaded('niveau')),
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
