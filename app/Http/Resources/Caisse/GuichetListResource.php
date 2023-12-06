<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\SiteResource;
use App\Models\Caisse\Guichet;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Guichet resource
 */
class GuichetListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'site_id' => $this->whenNotNull($this->resource->site_id),
            'nom' => $this->whenNotNull($this->resource->nom),
            'created_at' => $this->whenNotNull($this->resource->created_at?->format('d-m-Y')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
