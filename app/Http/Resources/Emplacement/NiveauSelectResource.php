<?php

namespace App\Http\Resources\Emplacement;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class NiveauSelectResource extends JsonResource
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
            'texte' => $this->nom . ' ' . $this->whenLoaded('pavillon', fn () => Str::lower($this->pavillon->nom)) . ' ' .
                $this->whenLoaded('site', fn () => Str::lower($this->site->nom)),
        ];
    }
}
