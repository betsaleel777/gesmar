<?php

namespace App\Http\Resources\Emplacement;

use App\Http\Resources\SiteResource;
use App\Models\Architecture\Zone;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Zone resource
 */
class ZoneResource extends JsonResource
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
            'niveau_id' => $this->resource->niveau_id,
            'nom' => $this->when(!empty($this->nom), str($this->resource->nom)->lower()),
            'code' => $this->whenNotNull($this->resource->getCode()),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'niveau' => NiveauResource::make($this->whenLoaded('niveau')),
        ];
    }
}
