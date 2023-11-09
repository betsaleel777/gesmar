<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\SiteResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Commercial resource
 */
class CommercialListResource extends JsonResource
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
            'code' => $this->whenNotNull($this->resource->code),
            'created_at' => $this->whenNotNull($this->resource->created_at?->format('d-m-Y')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
