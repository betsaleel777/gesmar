<?php

namespace App\Http\Resources;

use App\Models\Architecture\ServiceAnnexe;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property ServiceAnnexe $resource
 */
class ServiceAnnexeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'code' => $this->whenNotNull($this->resource->code),
            'nom' => $this->whenNotNull($this->resource->nom),
            'description' => $this->whenNotNull($this->resource->description),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
