<?php

namespace App\Http\Resources\Bordereau;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'code' => $this->code,
            'commercial_id' => $this->commercial_id,
            'date_attribution' => $this->date_attribution,
            'status' => $this->whenAppended('status'),
            'commercial' => CommercialResource::make($this->whenLoaded('commercial')),
            'attributions' => AttributionResource::collection($this->whenLoaded('attributions')),
        ];
    }
}
