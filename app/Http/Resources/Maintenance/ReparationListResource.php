<?php

namespace App\Http\Resources\Maintenance;

use App\Models\Exploitation\Reparation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Reparation $resource
 */
class ReparationListResource extends JsonResource
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
            'status' => $this->resource->status,
            'titre' => $this->resource->titre,
            'created_at' => $this->resource->created_at->format('d-m-Y'),
            'emplacement' => $this->whenLoaded('emplacement', $this->resource->emplacement->code),
        ];
    }
}
