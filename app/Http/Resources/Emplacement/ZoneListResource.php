<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ZoneListResource extends JsonResource
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
            'nom' => Str::lower($this->nom),
            'niveau_id' => $this->niveau_id,
            'created_at' => $this->created_at->format('d-m-Y'),
            'niveau' => $this->whenLoaded('niveau', fn () => Str::lower($this->niveau->nom)),
            'pavillon' => $this->whenLoaded('pavillon', fn () => Str::lower($this->pavillon->nom)),
            'site' => $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
        ];
    }
}
