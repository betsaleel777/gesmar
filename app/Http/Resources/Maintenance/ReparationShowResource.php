<?php

namespace App\Http\Resources\Maintenance;

use App\Http\Resources\Emplacement\EmplacementResource;
use App\Http\Resources\SiteResource;
use App\Models\Exploitation\Reparation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Reparation $resource
 */
class ReparationShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'code' => $this->resource->code,
            'titre' => $this->resource->titre,
            'status' => $this->resource->status,
            'description' => $this->resource->description,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'first' => $this->whenLoaded('first', $this->resource->first->getUrl()),
            'second' => $this->whenLoaded('second', $this->resource->second->getUrl()),
            'site' => $this->whenLoaded('site', SiteResource::make($this->resource->site)),
            'emplacement' => $this->whenLoaded('emplacement', EmplacementResource::make($this->resource->emplacement)),
        ];
    }
}
