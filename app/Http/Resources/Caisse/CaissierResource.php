<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CaissierResource extends JsonResource
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
            'user_id' => $this->whenNotNull($this->user_id),
            'code' => $this->whenNotNull($this->code),
            'user' => UserResource::make($this->whenLoaded('user')),
            'attributions' => AttributionGuichetResource::collection($this->whenLoaded('attributionsGuichet')),
        ];
    }
}
