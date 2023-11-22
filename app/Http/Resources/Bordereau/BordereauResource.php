<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\SiteResource;
use App\Models\Bordereau\Bordereau;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Bordereau resource
 */
class BordereauResource extends JsonResource
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
            'code' => $this->whenNotNull($this->code),
            'status' => $this->whenNotNull($this->status),
            'jour' => $this->whenNotNull($this->jour?->format('d-m-Y')),
            'commercial' => CommercialResource::make($this->whenLoaded('commercial')),
            'site' => SiteResource::make($this->whenLoaded('site')),
        ];
    }
}
