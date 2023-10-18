<?php

namespace App\Http\Resources\Maintenance;

use App\Models\Exploitation\Technicien;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Technicien resource
 */
class TechnicienSelectResource extends JsonResource
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
            'texte' => $this->resource->getAlias(),
        ];
    }
}
