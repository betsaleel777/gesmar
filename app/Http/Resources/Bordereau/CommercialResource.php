<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\SiteResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CommercialResource extends JsonResource
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
            'user_id' => $this->whenNotNull($this->user_id),
            'site_id' => $this->whenNotNull($this->site_id),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
