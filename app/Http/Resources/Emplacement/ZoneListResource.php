<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\Zone;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Zone resource
 */
class ZoneListResource extends JsonResource
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
            'nom' => $this->when(!empty($this->resource->nom), $this->resource->nom),
            'niveau_id' => $this->resource->niveau_id,
            'created_at' => $this->whenNotNull($this->resource->created_at?->format('d-m-Y')),
            'niveau' => NiveauResource::make($this->whenLoaded('niveau')),
            'pavillon' => PavillonResource::make($this->whenLoaded('pavillon')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
