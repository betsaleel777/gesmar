<?php

namespace App\Http\Resources\Bordereau;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'id' => $this->id,
            'code' => $this->code,
            'user_id' => $this->user_id,
            'site_id' => $this->site_id,
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
            'name' => $this->whenLoaded('user', fn () => Str::lower($this->user->name)),
        ];
    }
}
