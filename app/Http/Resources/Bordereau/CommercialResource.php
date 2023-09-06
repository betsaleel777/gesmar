<?php

namespace App\Http\Resources\Bordereau;

use App\Http\Resources\SiteResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'code' => $this->code,
            'user_id' => $this->user_id,
            'site_id' => $this->site_id,
            'name' => $this->whenLoaded('user', fn () => Str::lower($this->user->name)),
            'site' => SiteResource::make($this->whenLoaded('site')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'attributions' => AttributionResource::collection($this->whenLoaded('attributions')),
            'bordereaux' => BordereauResource::collection($this->whenLoaded('bordereaux')),
        ];
    }
}
