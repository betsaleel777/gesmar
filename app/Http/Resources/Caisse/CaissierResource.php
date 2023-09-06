<?php

namespace App\Http\Resources\Caisse;

use App\Http\Resources\Bordereau\AttributionResource;
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
            'code' => $this->code,
            'user' => UserResource::make($this->whenLoaded('user')),
            'attributions' => AttributionGuichetResource::collection($this->whenLoaded('attributionsGuichet')),
        ];
    }
}
