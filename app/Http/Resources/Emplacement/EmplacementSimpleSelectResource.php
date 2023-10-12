<?php

namespace App\Http\Resources\Emplacement;

use App\Models\Architecture\Emplacement;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Emplacement $resource
 */
class EmplacementSimpleSelectResource extends JsonResource
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
        ];
    }
}
