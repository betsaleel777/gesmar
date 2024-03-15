<?php

namespace App\Http\Resources\Emplacement;

use App\Models\Architecture\Zone;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Zone resource
 */
class ZoneSelectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'texte' => $this->resource->getLongName(),
        ];
    }
}
