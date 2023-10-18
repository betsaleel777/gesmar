<?php

namespace App\Http\Resources\Maintenance;

use App\Http\Resources\SiteResource;
use App\Models\Exploitation\Technicien;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Technicien $resource
 */
class TechnicienListResource extends JsonResource
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
            'interne' => $this->resource->interne,
            'nom_complet' => $this->resource->nom_complet,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'site' => $this->whenLoaded('site', SiteResource::make($this->resource->site)),
        ];
    }
}
