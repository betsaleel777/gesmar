<?php

namespace App\Http\Resources;

use App\Models\Architecture\Site;
use Illuminate\Http\Resources\Json\JsonResource;
use Str;

/**
 * @property Site $resource
 */
class SiteSelectResource extends JsonResource
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
            'nom' => Str::lower($this->resource->nom),
        ];
    }
}
