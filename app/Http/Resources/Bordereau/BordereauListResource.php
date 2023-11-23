<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\SiteResource;
use App\Models\Bordereau\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau resource
 */
class BordereauListResource extends JsonResource
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
            'jour' => $this->whenNotNull($this->jour?->format('d-m-Y')),
            'created_at' => $this->whenNotNull($this->resource->created_at?->format('d-m-Y')),
            'status' => $this->whenNotNull($this->resource->status),
            'commercial' => CommercialResource::make($this->whenLoaded('commercial')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
