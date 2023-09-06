<?php

namespace App\Http\Resources\Bordereau;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CommercialSelectResource extends JsonResource
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
            'texte' => $this->whenLoaded('user', fn () => Str::lower($this->user->name)),
        ];
    }
}
